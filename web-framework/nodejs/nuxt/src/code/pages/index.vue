<template>
  <div class="container">
    <div>
      <logo />
      <h1 class="title">
        Greetings from Nuxt.js!
      </h1>
      <h2 class="subtitle">
        The web app is hosted on Aliyun <a href="https://www.aliyun.com/product/fc" target="_blank">FunctionCompute</a>.
      </h2>
      <div class="links">
        <a
          href="https://help.aliyun.com/document_detail/157957.html"
          target="_blank"
          class="button--green"
        >
          Documentation
        </a>
        <a
          href="https://github.com/awesome-fc/fc-web-examples/tree/master/nuxtjs"
          target="_blank"
          class="button--grey"
        >
          GitHub
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import Logo from '~/components/Logo.vue'

export default {
  components: {
    Logo
  }
}
</script>

<style>
.container {
  margin: 0 auto;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.title {
  font-family: 'Quicksand', 'Source Sans Pro', -apple-system, BlinkMacSystemFont,
    'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  display: block;
  font-weight: 300;
  font-size: 50px;
  color: #35495e;
  letter-spacing: 1px;
}

.subtitle {
  font-weight: 300;
  font-size: 22px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.links {
  padding-top: 15px;
}
</style>
