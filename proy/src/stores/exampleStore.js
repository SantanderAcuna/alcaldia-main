import { defineStore } from "pinia";
import { ref, computed } from "vue";

export const useExampleStore = defineStore("example", () => {
  // Estado reactivo
  const counter = ref(0);
  const user = ref(null);

  // Getters (computados)
  const isAuthenticated = computed(() => user.value !== null);

  // Actions (funciones)
  function increment() {
    counter.value++;
  }

  function setUser(userData) {
    user.value = userData;
  }

  return {
    counter,
    user,
    isAuthenticated,
    increment,
    setUser,
  };
});
