<!-- DropdownMenu.vue -->
<template>
    <div class="relative inline-block text-left">
      <button @click="toggleMenu" class="p-1 pl-2 ml-1 btn-primary">
        <i class="text-lg ri-more-fill"></i>
      </button>
      <transition name="fade">
        <div v-if="isOpen" class="dropdown-menu" @click.away="closeMenu">
          <slot></slot>
        </div>
      </transition>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isOpen: false,
      };
    },
    methods: {
      toggleMenu() {
        this.isOpen = !this.isOpen;
      },
      closeMenu() {
        this.isOpen = false;
      },
    },
  };
  </script>
  
  <style>
  .dropdown-menu {
    position: absolute;
    right: 0;
    background: white;
    border: 1px solid #ccc;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    min-width: 160px;
    padding: 10px 0;
  }
  .dropdown-menu::before {
    content: '';
    position: absolute;
    top: -5px;
    right: 10px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent white transparent;
  }
  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0;
  }
  </style>
  