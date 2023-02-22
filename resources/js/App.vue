<template>
  <div class="box">
    <h1 class="title">Task title: </h1>
      <code>
        Сделать приложение на Laravel +vue, где пользователь загружает документ word c текстом,
         в котором есть хотя бы одна переменная, которую пользователь может ввести в input.
        На выходе получить pdf c текстом word-а и замененной переменной. Структура pdf,
         формат отступы должны максимально соответствовать загруженному файлу Word.
          После выполнения прислать ссылку на github
      </code>
      <hr>
    <FileForm />
  </div>
</template>

<script setup lang="ts">
import FileForm from './components/FileForm.vue';
</script>
<style>
.box {
  margin: 100px auto;
  width: 800px;
}
.title {
  font-size: 20px;
  font-weight: 600;
}
hr{
  margin-bottom: 20px;
}
</style>
