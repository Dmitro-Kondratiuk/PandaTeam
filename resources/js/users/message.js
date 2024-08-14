import "../app.js"
import axios from "axios";

const form = document.getElementById('messageForm')
form.addEventListener('submit', sendMessage)
let messageResponse = document.getElementById('messageResponse')
document.addEventListener('DOMContentLoaded', showMessage);

async function sendMessage(event) {
    event.preventDefault()
    let formData = new FormData(form)
    formData.append('received_id', 4)
    let response = await axios.post('/createMessage', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });

    let data = response.data
    if(data.creater_id === data.message.sender_id){
        let senderReturn = `
            <div class="message sent">
                <div class="message-header">
                    <strong>Вы</strong> в 14:37
                </div>
                <div class="message-content">${data.message.message}</div>
            </div>`
        messageResponse.innerHTML += senderReturn
    }else {
        let senderReturn = `
                 <div class="message received">
            <div class="message-header">
                <strong>Другой Пользователь</strong> в 14:35
            </div>
            <div class="message-content">${data.message.message}</div>
        </div>`
        messageResponse.innerHTML += senderReturn
    }


}

async function showMessage(){
    let response = await axios.get('/getMessage')
    let data  = response.data

    data.messages.forEach(message =>{
        if(data.creater_id === message.sender_id){
            let senderReturn = `
            <div class="message sent">
                <div class="message-header">
                    <strong>Вы</strong> в 14:37
                </div>
                <div class="message-content">${message.message}</div>
            </div>`
            messageResponse.innerHTML += senderReturn
        }else {
            let senderReturn = `
                 <div class="message received">
            <div class="message-header">
                <strong>Другой Пользователь</strong> в 14:35
            </div>
            <div class="message-content">${message.message}</div>
        </div>`
            messageResponse.innerHTML += senderReturn
        }
    })
}

window.Echo.channel('store_message').listen('.store_message', res => {
    if(res.creater_id === res.message.sender_id){
        let senderReturn = `
            <div class="message sent">
                <div class="message-header">
                    <strong>Вы</strong> в 14:37
                </div>
                <div class="message-content">${res.message.message}</div>
            </div>`
        messageResponse.innerHTML += senderReturn
    }else {
        let senderReturn = `
                 <div class="message received">
            <div class="message-header">
                <strong>Другой Пользователь</strong> в 14:35
            </div>
            <div class="message-content">${res.message.message}</div>
        </div>`
        messageResponse.innerHTML += senderReturn
    }
})


