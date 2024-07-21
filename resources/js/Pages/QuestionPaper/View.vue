<template>
  <div>
    <h1>Question Paper</h1>
    <div v-for="question in questions" :key="question.id">
      <h2>{{ question.title }}</h2>
      <p v-if="question.question_description" v-html="question.question_description"></p>
      <ul>
        <li v-if="question.choice_a">A: {{ question.choice_a }}</li>
        <li v-if="question.choice_b">B: {{ question.choice_b }}</li>
        <li v-if="question.choice_c">C: {{ question.choice_c }}</li>
        <li v-if="question.choice_d">D: {{ question.choice_d }}</li>
      </ul>
      <p v-if="question.correct_answer">Correct Answer: {{ question.correct_answer }}</p>
      <p v-if="question.status">Status: {{ question.status }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    questions: {
      type: Array,
      required: true
    }
  }
}
</script>
