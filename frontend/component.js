Vue.use(VeeValidate)

const store = new Vuex.Store({
  state: {
    count: 8,
    title: 'halo',
    placeholder: '',
    autocomplete: '',
    readonly: '',
  },

  mutations: {
    updatePlaceholder (state, placeholder) {
      state.placeholder = placeholder
    },

    updateAutocomplete (state, autocomplete) {
      state.autocomplete = autocomplete
    },

    updateReadonly (state, readonly) {
      state.readonly = readonly
    }
  }
})

Vue.component('input-text', {
  template: '#input-text',

  computed: {
    title () {
	    return store.state.title
    },

    autocomplete: {
      get () {
        return store.state.autocomplete
      },
      set (value) {
        store.commit('updateAutocomplete', value)
      }
    },

    placeholder: {
      get () {
        return store.state.placeholder
      },
      set (value) {
        store.commit('updatePlaceholder', value)
      }
    },

    readonly: {
      get () {
        return store.state.readonly
      },
      set (value) {
        store.commit('updateReadonly', value)
      }
    },
  },
});

new Vue({
  el: '#app',

  computed: {
    title () {
	    return store.state.title
    }
  },

  data: function(){
    return {
      columns: ['Name', 'Variable Name', 'HTML Basic'],
      inputType: ['text','number','textarea','date','radio','checkbox','dropdown'],
      components: [],
      modal_header: '',
      data_input: [],
      selected_type: '',
      inputComponent: {},
      view_data:[],
      alert: false,
      attributs: [{
        attribut: '',
        value: '',
        count: 1
        }
      ],
      count: 1,

      options: [{
        option: '',
        countOption: 1
        }
      ],
      countOptions: 1,

    }
  },

  mounted() {
    this.init()


  },

  methods: {
    async init(){
      const response = await axios.get('/e-letter/component/index2')
      this.components = response.data
      $(this.$refs.vuemodal).hide()
    },

    deleteComponent(id){
      axios.delete('/e-letter/component/delete/' + id)
      .then(response => {
        this.init()
      })
    },

    destroy(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {

        if (result.value) {
          this.deleteComponent(id)
          Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Data deleted successful',
            showConfirmButton: false,
            timer: 1500
          })
        }
      })
    },

    addComponent(){
      this.$validator.validate().then(valid => {
          if (valid) {
            const newComponent = new URLSearchParams()
            newComponent.append('name', this.inputComponent.name)
            newComponent.append('variable_name', this.inputComponent.variable_name)
            newComponent.append('type', this.inputComponent.type)
            for (var i = 0; i < this.attributs.length; i++) {
              newComponent.append(this.attributs[i].attribut, this.attributs[i].value)
            }
            for (var i = 0; i < this.options.length; i++) {
              if (this.options[i].option != '') {
                newComponent.append('option[]', this.options[i].option)
              }
            }

            axios.post('/e-letter/component/create', newComponent)
            .then((response) => {

              this.init()
              $('#modal-form').modal('hide');
              Swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Data saved successful',
                showConfirmButton: false,
                timer: 1500
              })
            })
            .catch((e) => {
              console.log(e)
            })
          }
        })
    },

    updateComponent(id){
      this.$validator.validate().then(valid => {
          if (valid) {
            const newComponent = new URLSearchParams()
            newComponent.append('name', this.inputComponent.name)
            newComponent.append('variable_name', this.inputComponent.variable_name)
            newComponent.append('type', this.inputComponent.type)
            for (var i = 0; i < this.attributs.length; i++) {
              newComponent.append(this.attributs[i].attribut, this.attributs[i].value)
            }
            for (var i = 0; i < this.options.length; i++) {
              if (this.options[i].option != '') {
                newComponent.append('option[]', this.options[i].option)
              }
            }

            axios.post('/e-letter/component/update/'+id, newComponent)
            .then((response) => {

              this.init()
              $('#modal-form').modal('hide');
              Swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Data updated successful',
                showConfirmButton: false,
                timer: 1500
              })
            })
            .catch((e) => {
              console.log(e)
            })
          }

        })

    },

    async newComponent(){
      this.errors.clear()
      this.modal_header = 'New Component'
      const response = await axios.get('/e-letter/component/list_input')
      this.data_input = response.data
      this.count = 1
      this.countOption = 1
      this.attributs = [{
        attribut: '',
        value: '',
        count: 1
        }
      ]
      this.options = [{
        option: '',
        countOption: 1
        }
      ]

      this.inputComponent = {}
    },

    editComponent(id){
      this.errors.clear()
      this.options = [{
        option: '',
        countOption: 1
        }
      ]
      this.attributs = [{
        attribut: '',
        value: '',
        count: 1
        }
      ]
      var option = {}
      var attribut = {}
      this.inputComponent = {}
      this.modal_header = 'Edit Component'
      this.inputComponent.id = id
      this.inputComponent.type = this.components.find(x => x.id === id).attribut.type
      this.inputComponent.name = this.components.find(x => x.id === id).name
      this.inputComponent.variable_name = this.components.find(x => x.id === id).variable_name

      if (this.inputComponent.type == 'radio' || this.inputComponent.type == 'checkbox' || this.inputComponent.type == 'dropdown') {
        option = this.components.find(x => x.id === id).option
      }
      attribut = this.components.find(x => x.id === id).attribut

      if (option !== "undefined") {
        for (var i = 0; i < option.length; i++) {
          this.options[i] = {
            option: option[i],
            countOption: i+1
            }
        }
      }

      var j = 0
      for (var key in attribut) {
        if (attribut.hasOwnProperty(key)) {
          if (key != "type") {
            this.attributs[j] = {
              attribut: key,
              value: attribut[key],
              count: j+1
              }
            j++;
          }
         }
      }

    },

    onChange(event) {
      this.selected_type = event.target.value
      this.inputComponent.type = event.target.value

    },

    addAttribut() {
      this.count = this.attributs.length

      this.attributs.push({
        attribut: '',
        count: ++this.count
      });
    },

    addOption() {
      this.countOption = this.options.length
      this.options.push({
        option: '',
        countOption: ++this.countOption
      });
    },

    view(id) {
      this.view_data = this.components.find(x => x.id === id)

    },

    removeOption(index) {
      this.options.splice(index, 1)

    },

    removeAttribut(index) {
      this.attributs.splice(index, 1)

    },
  }
});
