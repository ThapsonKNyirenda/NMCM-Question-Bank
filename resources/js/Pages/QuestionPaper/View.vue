<template>
  <div class="question-paper">
    <h1 class="title">Generated Question Paper</h1>
    <ul>
      <li v-for="(question, index) in questions" :key="question.id" class="question-item">
        <h2 class="question-number">Question {{ index + 1 }}</h2>
        <p class="question-title">{{ question.title }}</p>
        <div class="question-description">{{ question.description }}</div>
        <ul class="choices-list">
          <li class="choice-item">A. {{ question.choice_a }}</li>
          <li class="choice-item">B. {{ question.choice_b }}</li>
          <li class="choice-item">C. {{ question.choice_c }}</li>
          <li class="choice-item">D. {{ question.choice_d }}</li>
        </ul>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { defineProps } from 'vue';
import axios from 'axios';

const props = defineProps({
  questionIds: Array
});

const questions = ref([]);

const fetchQuestions = async () => {
  try {
    const response = await axios.get('/api/questions/by-ids', {
      params: {
        ids: props.questionIds
      }
    });
    questions.value = response.data;
  } catch (error) {
    console.error('Error fetching questions:', error);
  }
};

onMounted(fetchQuestions);
</script>

<style scoped>
.question-paper {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  font-family: 'Times New Roman', Times, serif;
  line-height: 1.6;
  background-color: #fff;
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.title {
  text-align: center;
  font-size: 24px;
  margin-bottom: 20px;
}

.questions-list {
  list-style: decimal inside;
  padding: 0;
}

.question-item {
  margin-bottom: 20px;
}

.question-number {
  font-weight: bold;
  margin-bottom: 5px;
}

.question-title {
  font-weight: bold;
  margin-bottom: 5px;
}

.question-description {
  margin-bottom: 10px;
}

.choices-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.choice-item {
  margin-bottom: 5px;
}

.choice-item::before {
  content: attr(value);
  display: inline-block;
  width: 20px;
}
</style>
