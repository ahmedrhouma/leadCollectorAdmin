import params from './config.js'
var messenger = (function (options) {
    let defaultOptions = {
        key: '',
        account_id: '',
        welcomeMSG: 'Welcome ,<br> we are ready to chat with you!',
    };
    options = {...defaultOptions, ...options,...params};
    let chatBlock;
    let chatBody;
    let chatMainButton;
    let replyMessage;
    let receiveMessage;
    let welcomeMsg;
    let conversation;
    let messageInput;
    let input;

    var init = function () {
        chatBlock = document.createElement('div');
        chatBody = document.createElement('div');
        replyMessage = document.createElement('div');
        chatMainButton = document.createElement("img");
        welcomeMsg = document.createElement("div");
        receiveMessage = document.createElement("div");
        conversation = document.createElement("div");
        messageInput = document.createElement("div");
        setStyle(messageInput, 'display', 'flex');
        input = document.createElement("input");
        let sendButton = document.createElement("button");
        sendButton.innerText = "Send";
        setStyle(sendButton, 'color', '#fff');
        setStyle(sendButton, 'border-color', '#5e72e4');
        setStyle(sendButton, 'box-shadow', '0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%)');
        setStyle(sendButton, 'font-size', '.875rem');
        setStyle(sendButton, 'font-weight', '600');
        setStyle(sendButton, 'padding', '.625rem 1.25rem');
        setStyle(sendButton, 'border', '1px solid transparent');
        setStyle(sendButton, 'border-radius', '0 1rem 1rem 0');
        setStyle(sendButton, 'background-color', '#66cc70');
        sendButton.addEventListener('click', sendMessage);
        messageInput.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                sendButton.click();
            }
        });
        setStyle(input, 'font-size', '.875rem');
        setStyle(input, 'width', '100%');
        setStyle(input, 'padding', '.625rem .75rem');
        setStyle(input, 'color', ' #8898aa');
        setStyle(input, 'border', '1px solid #dee2e6');
        setStyle(input, 'border-radius', '1rem 0 0 1rem');
        //sendButton.addEventListener('click',sendMessage);
        messageInput.appendChild(input);
        messageInput.appendChild(sendButton);
        setStyle(welcomeMsg, 'height', '70%');
        setStyle(welcomeMsg, 'display', 'flex');
        setStyle(welcomeMsg, 'align-items', 'center');
        setStyle(welcomeMsg, 'justify-content', 'center');
        setStyle(welcomeMsg, 'text-align', 'center');

        let startBtn = document.createElement("div");
        startBtn.appendChild(document.createTextNode("Chat now"));
        setStyle(startBtn, 'padding', '15px');
        setStyle(startBtn, 'text-align', 'center');
        setStyle(startBtn, 'border-top', '1px solid gainsboro');
        setStyle(startBtn, 'font-weight', '800');
        setStyle(startBtn, 'cursor', 'pointer');
        setStyle(startBtn, 'font-size', '20px');
        startBtn.addEventListener('click', startConversation);

        welcomeMsg.innerHTML = options.welcomeMSG;
        let closeIcon = document.createElement("img");
        setStyle(closeIcon, 'width', '20px');
        setStyle(closeIcon, 'cursor', 'pointer');
        closeIcon.addEventListener('click', toggleChat);
        closeIcon.src = "https://beta.myplatform.pro/sdk/img/close.svg";

        chatMainButton.src = "https://beta.myplatform.pro/sdk/img/message.svg";
        chatMainButton.addEventListener('click', toggleChat);
        setGraphicStyles();
        chatBody.appendChild(closeIcon);
        chatBody.appendChild(welcomeMsg);
        chatBody.appendChild(conversation);
        chatBody.appendChild(startBtn);
        chatBlock.appendChild(chatBody);
        chatBlock.appendChild(chatMainButton);
        document.body.appendChild(chatBlock);
    };

    var setGraphicStyles = function () {
        setStyle(chatBlock, 'position', 'absolute');
        setStyle(chatBlock, 'right', '25px');
        setStyle(chatBlock, 'bottom', '50px');

        setStyle(replyMessage, 'padding', '10px');
        setStyle(replyMessage, 'background-color', '#87e694');
        setStyle(replyMessage, 'border-radius', '20px');
        setStyle(replyMessage, 'color', '#565656');
        setStyle(replyMessage, 'font-size', '15px');
        setStyle(replyMessage, 'margin-bottom', '10px');
        setStyle(replyMessage, 'width', '70%');
        setStyle(replyMessage, 'animation', 'expand .5s ease-in-out');
        setStyle(replyMessage, 'float', 'left');


        setStyle(receiveMessage, 'padding', '10px');
        setStyle(receiveMessage, 'background-color', '#172b4d');
        setStyle(receiveMessage, 'border-radius', '20px');
        setStyle(receiveMessage, 'color', 'white');
        setStyle(receiveMessage, 'font-size', '15px');
        setStyle(receiveMessage, 'float', 'right');
        setStyle(receiveMessage, 'width', '70%');
        setStyle(receiveMessage, 'margin-bottom', '10px');
        setStyle(receiveMessage, 'animation', 'expand .5s ease-in-out');

        setStyle(conversation, 'height', '70%');
        setStyle(conversation, 'padding-top', '10px');
        setStyle(conversation, 'display', 'none');
        setStyle(conversation, 'overflow-y', 'auto');
        setStyle(conversation, '-webkit-scrollbar-track', 'auto');
        let style = document.createElement('style');
        document.head.appendChild(style);
        conversation.classList.add("leadConversation")
        style.sheet.insertRule('.leadConversation::-webkit-scrollbar-track{-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1);background-color: #F5F5F5;border-radius: 10px;}', 0);
        style.sheet.insertRule('.leadConversation::-webkit-scrollbar-thumb{border-radius: 10px;background-color: #FFF;background-image: -webkit-gradient(linear,40% 0%,75% 84%,from(#172b4d),to(#172b4d),color-stop(.6,#172b4d))}', 0);
        style.sheet.insertRule('.leadConversation::-webkit-scrollbar{width: 10px;background-color: #F5F5F5;}', 0);
        setStyle(chatBody, 'padding', '10px');
        setStyle(chatBody, 'height', '250px');
        setStyle(chatBody, 'width', '300px');
        setStyle(chatBody, 'display', 'block');
        setStyle(chatBody, 'background-color', 'white');
        setStyle(chatBody, 'border-radius', '15px');
        setStyle(chatBody, 'border', '1px solid lightgray');

        setStyle(chatMainButton, 'height', '60px');
        setStyle(chatMainButton, 'width', '60px');
        setStyle(chatMainButton, 'float', 'right');
        setStyle(chatMainButton, 'border-radius', '50%');
        setStyle(chatMainButton, 'margin', '20px 0px');
        setStyle(chatMainButton, 'cursor', 'pointer');
    };

    function toggleChat() {
        chatBody.style.display = chatBody.style.display === "block" ? "none" : "block";
    }

    var setStyle = function (dom, prop, value) {
        dom.style.setProperty(prop, value);
    };
    var startConversation = async function () {
        parentNode.removeChild(this);
        chatBody.removeChild(welcomeMsg);
        conversation.style.display = "block";
        chatBody.appendChild(messageInput);

        let result = await sendRequest('https://beta.myplatform.pro/live/message', 'POST', JSON.stringify({
            key: options.key,
            browser_data: navigator.userAgent,
            message: "",
            identifier: localStorage.getItem('identifier')
        }));
        localStorage.setItem('identifier', result.identifier);
        result.messages.forEach(message => {
            let msg = replyMessage.cloneNode();
            msg.innerHTML = message;
            reply(msg)
        });
    };
    var sendMessage = async function () {
        let msg = receiveMessage.cloneNode();
        let text = input.value;
        msg.innerHTML = text;
        input.value = "";
        reply(msg);
        let result = await sendRequest('https://beta.myplatform.pro/live/message', 'POST', JSON.stringify({
            key: options.key,
            message: text,
            identifier: localStorage.getItem('identifier')
        }));
        result.messages.forEach(message => {
            let msg = replyMessage.cloneNode();
            msg.innerHTML = message;
            reply(msg)
        });
    };

    function sendRequest(url, method, data = "") {
        return new Promise(function (resolve, reject) {
            const Http = new XMLHttpRequest();
            Http.open(method, url);
            Http.setRequestHeader("Accept", "application/json");
            Http.setRequestHeader("Content-Type", "application/json");
            Http.onreadystatechange = function () {
                if (Http.readyState === 4 && Http.responseText != "") {
                    resolve(JSON.parse(Http.responseText));
                }
            };
            Http.send(data);
        });
    }

    function reply(message) {
        conversation.appendChild(message);
        conversation.scrollTo(0, conversation.scrollHeight);
    }
    init();
    return this
})();
