<template>

  <!--Theme switch-->
  <div style="position: fixed; botom: 0px; right: 0px; margin: 20px" :style="this.darkTheme && 'color: #fff'"
       @click="this.darkTheme = !this.darkTheme">
    {{ darkTheme ? 'Light' : 'Dark' }} Style
  </div>

  <Chat
      :name="this.name"
      :onSend="sendMessage"
      :chat="this.messages"
      :width="600"
      :bgColorHeader="this.darkTheme && '#1e1e1e'"
      :bgColorChat="this.darkTheme && '#2C2D2E'"
      :bgColorInput="this.darkTheme && '#1e1e1e'"
      :bgColorIcon="this.darkTheme && '#9B51E0'"
      :bgColorMessageChatbot="this.darkTheme && '#1e1e1e'"
      :bgColorMessagePerson="this.darkTheme && '#9B51E0'"
      :bgColorMessageTimestamp="this.darkTheme && '#1e1e1e'"
      :textColorInput="this.darkTheme && '#fff'"
      :textColorHeader="this.darkTheme && '#fff'"
      :textColorMessageChatbot="this.darkTheme && '#fff'"
      :textColorMessageTimestamp="this.darkTheme && '#fff'"
  />
</template>
<script>

import {Chat} from '@chat-ui/vue3'
import Talk from 'talkjs';



export default {
  name: 'CloudFlare',
  props: {

  },
  components: {
    Chat,
  },
  data() {
    return {
      darkTheme: true,
      name: 'CloudFlare',
      messages: [
        {
          type: 'chatbot',
          message: 'Hello, how can I help you?',
          timestamp: '2021-08-01 12:00:00'
        },
      ]
    }
  },

  methods: {
    sendMessage(message) {
      this.messages.push({
        type: 'person',
        message: message,
        timestamp: new Date().toISOString().slice(0, 19).replace('T', ' ')
      })


      fetch('/cp/chat', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({
          message: message,
          _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        })
      })
          .then(response => {
            return response.json();
          })
          .then(response => {
            this.messages.push({
              type: 'chatbot',
              message: response.result.response,
              timestamp: new Date().toISOString().slice(0, 19).replace('T', ' ')
            })
          })
          .catch(error => {
            console.log(error);
          });

    }
  },

}

</script>