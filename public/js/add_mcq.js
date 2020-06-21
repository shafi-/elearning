let addMcq = new Vue({
  el: '#add_mcq',
  data() {
    return {
      mcq: {
        question: '',
        options: []
      },
      error: {
        errorCode: null,
        errros: {
          question: '',
          options: []
        }
      },
      addMore: false
    }
  },
  created() {
    this.resetForm();
    this.addMore = true;
  },
  methods: {
    getNewOption() {
      return {
        body: '',
        is_answer: false
      };
    },
    questionHelpText() {
      return this.error ? this.error.question : 'Question field is required'
    },
    optionHelpText(option, optionIndex) {
      return this.error && this.error.options ? this.error.options[optionIndex] : '';
    },
    optionPlaceholderText(optIdx) {
      return 'Option ' + (optIdx + 1) + ' text';
    },
    parseError() {},
    resetForm() {
      this.mcq.question = '',
      this.mcq.options = [];
      for(let i = 0; i < 4; i++)
        this.mcq.options.push(this.getNewOption());
      this.error = {
        errorCode: null,
        errros: {
          question: '',
          options: []
        }
      }
      this.addMore = false
    },
    submitForm(url) {
      console.log({
        url, 
        mcq: this.mcq
      });
      axios.post(url, this.mcq)
        .then(console.log)
        .then(() => this.addMore = true)
        .catch(console.error);
    }
  }
});
