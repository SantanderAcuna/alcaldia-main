<template>
  <div class="home">
    
    <HelloWorld msg="Alcaldia de santa marta"/>
  </div>
</template>

<script>
// @ is an alias to /src
//import HelloWorld from '@/components/HelloWorld.vue'
import Navbar from '@/components/layout/publico/Navbar.vue';

export default {
  name: 'HomeView',
  components: {
    
    Navbar
  }
}
</script>
