 function messenger(options) {
    let defaultOptions = {
        key: '',
        account_id: '',
        welcomeMSG: 'Welcome ,<br> we are ready to chat with you!',
    };
    options = {...defaultOptions, ...options};
    let chatBlock;
    let chatBody;
    let chatMainButton;
    let replyMessage;
    let receiveMessage;
    let welcomeMsg;
    let conversation;
    let messageInput;
    let input;
    this.init = function () {
        chatBlock = document.createElement('div');
        chatBody = document.createElement('div');
        replyMessage = document.createElement('div');
        chatMainButton = document.createElement("img");
        welcomeMsg = document.createElement("div");
        receiveMessage = document.createElement("div");
        conversation = document.createElement("div");
        messageInput = document.createElement("div");
        this.setStyle(messageInput, 'display', 'flex');

        input = document.createElement("input");
        let sendButton = document.createElement("button");
        sendButton.innerText = "Send";
        this.setStyle(sendButton, 'color', '#fff');
        this.setStyle(sendButton, 'border-color', '#5e72e4');
        this.setStyle(sendButton, 'box-shadow', '0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%)');
        this.setStyle(sendButton, 'font-size', '.875rem');
        this.setStyle(sendButton, 'font-weight', '600');
        this.setStyle(sendButton, 'padding', '.625rem 1.25rem');
        this.setStyle(sendButton, 'border', '1px solid transparent');
        this.setStyle(sendButton, 'border-radius', '0 1rem 1rem 0');
        this.setStyle(sendButton, 'background-color', '#66cc70');
        sendButton.addEventListener('click', this.sendMessage);
        messageInput.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                sendButton.click();
            }
        });
        this.setStyle(input, 'font-size', '.875rem');
        this.setStyle(input, 'width', '100%');
        this.setStyle(input, 'padding', '.625rem .75rem');
        this.setStyle(input, 'color', ' #8898aa');
        this.setStyle(input, 'border', '1px solid #dee2e6');
        this.setStyle(input, 'border-radius', '1rem 0 0 1rem');
        //sendButton.addEventListener('click',this.sendMessage);
        messageInput.appendChild(input);
        messageInput.appendChild(sendButton);
        this.setStyle(welcomeMsg, 'height', '70%');
        this.setStyle(welcomeMsg, 'display', 'flex');
        this.setStyle(welcomeMsg, 'align-items', 'center');
        this.setStyle(welcomeMsg, 'justify-content', 'center');
        this.setStyle(welcomeMsg, 'text-align', 'center');

        let startBtn = document.createElement("div");
        startBtn.appendChild(document.createTextNode("Chat now"));
        this.setStyle(startBtn, 'padding', '10px');
        this.setStyle(startBtn, 'text-align', 'center');
        this.setStyle(startBtn, 'border-top', '1px solid gainsboro');
        this.setStyle(startBtn, 'font-weight', '800');
        this.setStyle(startBtn, 'cursor', 'pointer');
        startBtn.addEventListener('click', this.startConversation);

        welcomeMsg.innerHTML = options.welcomeMSG;
        let closeIcon = document.createElement("img");
        this.setStyle(closeIcon, 'width', '20px');
        this.setStyle(closeIcon, 'cursor', 'pointer');
        closeIcon.addEventListener('click', toggleChat);
        closeIcon.src = "https://beta.myplatform.pro/sdk/img/close.svg";

        chatMainButton.src = "https://beta.myplatform.pro/sdk/img/message.svg";
        chatMainButton.addEventListener('click', toggleChat);
        this.setGraphicStyles();
        chatBody.appendChild(closeIcon);
        chatBody.appendChild(welcomeMsg);
        chatBody.appendChild(conversation);
        chatBody.appendChild(startBtn);
        chatBlock.appendChild(chatBody);
        chatBlock.appendChild(chatMainButton);
        document.body.appendChild(chatBlock);
    };

    this.setGraphicStyles = function () {
        this.setStyle(chatBlock, 'position', 'absolute');
        this.setStyle(chatBlock, 'right', '25px');
        this.setStyle(chatBlock, 'bottom', '50px');

        this.setStyle(replyMessage, 'padding', '10px');
        this.setStyle(replyMessage, 'background-color', '#87e694');
        this.setStyle(replyMessage, 'border-radius', '20px');
        this.setStyle(replyMessage, 'color', '#565656');
        this.setStyle(replyMessage, 'font-size', '15px');
        this.setStyle(replyMessage, 'margin-bottom', '10px');
        this.setStyle(replyMessage, 'width', '70%');
        this.setStyle(replyMessage, 'animation', 'expand .5s ease-in-out');
        this.setStyle(replyMessage, 'float', 'left');


        this.setStyle(receiveMessage, 'padding', '10px');
        this.setStyle(receiveMessage, 'background-color', '#172b4d');
        this.setStyle(receiveMessage, 'border-radius', '20px');
        this.setStyle(receiveMessage, 'color', 'white');
        this.setStyle(receiveMessage, 'font-size', '15px');
        this.setStyle(receiveMessage, 'float', 'right');
        this.setStyle(receiveMessage, 'width', '70%');
        this.setStyle(receiveMessage, 'margin-bottom', '10px');
        this.setStyle(receiveMessage, 'animation', 'expand .5s ease-in-out');

        this.setStyle(conversation, 'height', '70%');
        this.setStyle(conversation, 'padding-top', '10px');
        this.setStyle(conversation, 'display', 'none');
        this.setStyle(conversation, 'overflow-y', 'auto');
        this.setStyle(conversation, '-webkit-scrollbar-track', 'auto');
        let style = document.createElement('style');
        document.head.appendChild(style);
        conversation.classList.add("leadConversation")
        style.sheet.insertRule('.leadConversation::-webkit-scrollbar-track{-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1);background-color: #F5F5F5;border-radius: 10px;}', 0);
        style.sheet.insertRule('.leadConversation::-webkit-scrollbar-thumb{border-radius: 10px;background-color: #FFF;background-image: -webkit-gradient(linear,40% 0%,75% 84%,from(#172b4d),to(#172b4d),color-stop(.6,#172b4d))}', 0);
        style.sheet.insertRule('.leadConversation::-webkit-scrollbar{width: 10px;background-color: #F5F5F5;}', 0);
        this.setStyle(chatBody, 'padding', '10px');
        this.setStyle(chatBody, 'height', '250px');
        this.setStyle(chatBody, 'width', '300px');
        this.setStyle(chatBody, 'display', 'block');
        this.setStyle(chatBody, 'background-color', 'white');
        this.setStyle(chatBody, 'border-radius', '15px');

        this.setStyle(chatMainButton, 'height', '60px');
        this.setStyle(chatMainButton, 'width', '60px');
        this.setStyle(chatMainButton, 'float', 'right');
        this.setStyle(chatMainButton, 'border-radius', '50%');
        this.setStyle(chatMainButton, 'margin', '20px 0px');
        this.setStyle(chatMainButton, 'cursor', 'pointer');
    };

    function toggleChat() {
        chatBody.style.display = chatBody.style.display === "block" ? "none" : "block";
    }

    this.setStyle = function (dom, prop, value) {
        dom.style.setProperty(prop, value);
    };
    this.startConversation = async function () {
        this.parentNode.removeChild(this);
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
    this.sendMessage = async function () {
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

    this.init();
}
