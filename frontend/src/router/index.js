import { createMemoryHistory, createRouter } from 'vue-router'

import ListaDesenvolvedores from '@/components/ListaDesenvolvedores.vue'
import ListaNiveis from '@/components/ListaNiveis.vue'

const routes = [
  { path: '/', component: ListaNiveis },
  { path: '/desenvolvedores', component: ListaDesenvolvedores },
]

const router = createRouter({
  history: createMemoryHistory(),
  routes,
})

export default router
