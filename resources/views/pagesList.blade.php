<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        height: 100%;
        background-color: aliceblue;
        width: 100%;
        margin: 0;
        font-family: Helvetica, Arial, sans-serif;
        font-size: 12px;
    }
    .card{
        display: flex;
        justify-content: center;
        margin-top: 100px;
        border-radius: 15px;
        border: 1px solid #efefef;
    }
    .page-item {
        display: flex;
        align-items: center;
        margin: 15px;
    }
    .text-muted{
        color: #65676b;
    }
    .page-item img {
        border-radius: 50%
    }

    .page-item .name {
        margin-left: 10px;
    }
    hr{
        color: #bbbbbb;
    }
</style>
<body>
<div class="card col-4 mx-auto">
    <div class="card-body p-5">
        <h4>Facebook Pages you are using with LeadCollector</h4>
        <p class="text-muted mb-3">In the following list, you will find the Pages you selected..</p>
        <b>All Pages ({{ $total }})</b>
        <hr>
        @if($total == 0)
            <div>
                <b>No page granted</b>
                <p class="text-muted">You'll need to connect pages and grant them the required permissions in order for tokens to be generated.</p>
            </div>
        @else
        @foreach($facebookPages as $page)
            <div class="page-item">
                <div><img src="{{ $page['picture'] }}"></div>
                <div class="name"><h5>{{ $page['name'] }}</h5></div>
            </div>
        @endforeach
        @endif
        <hr>
        <div class="text-end">
            <a class="btn btn-primary" href="{{ $url }}">Add or remove pages</a>
        </div>
    </div>
</div>
</body>
</html>
