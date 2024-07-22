<template>
  <div>
    <h1>Question {{ question.title }}</h1>
    <p> Cadre: {{ question.cadre }}</p>
    <p> Nursing Process: {{ question.nursing_process }}</p>
    <p> Disease Area: {{ question.disease_area }}</p>
    <p> Taxonomy: {{ question.taxonomy }}</p>
    <p> Syllabus: {{ question.syllabus }}</p>
    <p> Question Description: {{ stripHtmlTags(question.question_description) }}</p>
    <p> Choices: {{ question.choice_a }}, {{ question.choice_b }}, {{ question.choice_c }}, {{ question.choice_d }}</p>
    <p> Correct Answer: {{ question.correct_answer }}</p>
  </div>
</template>

<script>
export default {
  props: {
    question: Object
  },
  methods: {
    stripHtmlTags(str) {
      // same implementation as in your original code
    }
  }
}
</script>