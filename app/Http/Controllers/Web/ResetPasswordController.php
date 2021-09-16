<?php

namespace App\Http\Controllers\Web;

use App\Classes\Matcher;
use App\Helper\Helper;
use App\Models\Access_keys;
use App\Models\Accounts;
use App\Models\Authorizations;
use App\Models\Channels;
use App\Models\Contacts;
use App\Models\Medias;
use App\Models\Requests;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class ResetPasswordController extends Controller
{
    public function resetPassword()
    {
        return view('auth.resetPassword');
    }

    public function resetPasswordVerify(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (is_null($user)) {
            return response()->json([
                'code' => "error",
                'messages' => "Email does not exist !!"
            ]);
        }
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
        );
        $now = new DateTimeImmutable();
        $token = $configuration->builder()
            ->issuedAt($now)
            ->withClaim('uid', $user->id)
            ->withClaim('action', "resetPassword")
            ->getToken($configuration->signer(), $configuration->signingKey());
        $data = [
            "token" => $token->toString()
        ];
        Mail::send('resetPasswordMail', $data, function ($message) use ($user) {
            $message->to($user->email)->subject
            ('Reset password on lead collector');
            $message->from('ahmedweldrhouma@gmail.com', 'Lead collector');
        });
        return response()->json([
            'code' => "success",
            'messages' => "please check your email !!"
        ]);
    }

    public function resetPasswordConfirm(Request $request, $token)
    {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
        );
        $token = $config->parser()->parse($token);
        $user = User::where('id', $token->claims()->get('uid'))->first();
        $action = $token->claims()->get('action');
        if ($user && $action == "resetPassword" && isset($request->reset)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            if ($user->waschanged()) {
                return redirect()->route('login');
            }
        }
        return view('auth.confirmResetPassword');
    }
}
