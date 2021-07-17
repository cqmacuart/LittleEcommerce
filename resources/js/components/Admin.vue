<template>
  <main class="container-fluid col-12 col-sm-8 shadow p-0">
    <!-- Header -->
    <Header :ruta="ruta"></Header>
    <!-- Navbar -->
    <Navbar :ruta="ruta"></Navbar>
    <!-- Contenido -->
    <div class="content-wrapper">
      <transition name="slide-fade" mode="out-in">
        <router-view :ruta="ruta"></router-view>
      </transition>
    </div>
    <Footer :ruta="ruta"></Footer>
  </main>
</template>

<script>
import Header from "./layouts/admin/Header";
import Navbar from "./layouts/admin/Navbar";
import Footer from "./layouts/admin/Footer";
export default {
  props: ["ruta"],
  components: {
    Header,
    Navbar,
    Footer,
  },
};
</script>

<style>
</style>
