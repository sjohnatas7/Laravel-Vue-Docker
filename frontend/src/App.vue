<template>
  <div class="container">
    <h1>CRUD Docker + Vue + Laravel</h1>
    <nav>
      <RouterLink to="/">Niveis</RouterLink>
      <RouterLink to="/desenvolvedores">Desenvolvedores</RouterLink>
    </nav>
    <main>
      <RouterView />
    </main>
  </div>
</template>

<style>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: Arial, sans-serif;
}

h1 {
  font-size: 2em;
  margin-bottom: 10px;
}

p {
  margin-bottom: 20px;
}

nav {
  display: flex;
  gap: 10px;
}

nav RouterLink {
  text-decoration: none;
  color: #333;
  padding: 5px 10px;
  background-color: #f0f0f0;
  border-radius: 5px;
}

nav RouterLink:hover {
  background-color: #e0e0e0;
}

main {
  margin-top: 20px;
}
</style>
