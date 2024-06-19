<script setup>
  import { reactive, computed } from 'vue';

  const props = defineProps(['show', 'data']);
  const state = reactive({ data: null });

  const inputData = computed({
    get() { return props.data; },
    set(newVal) { state.data = newVal },
  });
</script>

<template>
  <div v-show="show">
    <div class="modal">
      <div class="modal-inner">
        <input v-model="inputData">
        <button @click="$emit('save', state.data)">Save</button>
      </div>
    </div>
  </div>
</template>