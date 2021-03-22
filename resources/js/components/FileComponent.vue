<template>
  <div class="container">
    <form>
      <div class="form-row">
        <div class="form-group col-md-2">
          <label>Nr. unic (nr. format vechi)</label>
        </div>
        <div class="form-group col-md-6">
          <input v-model="file_number" type="text" class="form-control" disabled>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-2">
          <label>Sectie</label>
        </div>
        <div class="form-group col-md-6">
          <input type="text" class="form-control" placeholder="Sectia Penala" disabled>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-2">
          <label>Materie</label>
        </div>
        <div class="form-group col-md-6">
          <input type="text" class="form-control" placeholder="Penal" disabled>
        </div>
      </div>

      <h2>Obiecte</h2>
      <div class="crimes">	
	<div v-for="(fileCrime, index) in fileCrimes" :key="index" class="form-row">
	  <div class="form-group col-md-6 my-auto">
	    <select v-model="fileCrime.name" disabled>
	      <option v-for="crime in crimes">{{ crime.name }}</option>
	    </select>
	  </div>
	</div>
      </div>
 
      <hr>

      <h2>Parti</h2>
      <div class="parts">
        <div class="form-row" v-for="(part, index) in parts" :key="index">
          <div class="form-group col-md-6">
            <label>Nume</label>
            <input v-model="part.name" :name="`parts[${index}][name]`" type="text" class="form-control" placeholder="Nume" disabled>
          </div>
          <div class="form-group col-md-6">
            <label>Calitate parte</label>
            <select v-model="part.type" class="form-control" disabled>
              <option>Inculpat</option>
              <option>Parte civila</option>
              <option>Parte vatamata</option>
              <option>Parte responsabila civilmente</option>
            </select>
          </div>
        </div>
      </div>
      <h1>Sedinte</h1>
      <div class="trials">
        <div v-for="(trial, index) in trials" :key="index">
          <div v-if="trial.type === 'continued'">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Data judecarii</label>
              </div>
              <div class="form-group col-md-5">
                <datepicker-component v-model="trial.date" :language='ro' disabled>
                </datepicker-component>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Complet</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" :value="trial.court.name" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Solutie</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" value="Amanare cauza" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Tip solutie</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" v-model="trial.solution" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Document</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" v-model="trial.document" class="form-control" disabled>
              </div>
            </div>
          </div>
          <div v-if="trial.type === 'ended'">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Data judecarii</label>
              </div>
              <div class="form-group col-md-5">
                <datepicker-component v-model="trial.date" :language='ro' disabled>
                </datepicker-component>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Complet</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" :value="trial.court.name" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Solutie</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" value="Hotarare" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Tip solutie</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" v-model="trial.solution" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Document</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" v-model="trial.document" class="form-control" disabled>
              </div>
            </div>
          </div>
          <div v-if="trial.type === 'waiting' && timePassed(trial.date)">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Data judecarii</label>
              </div>
              <div class="form-group col-md-5">
                <datepicker-component v-model="trial.date" :language='ro' disabled>
                </datepicker-component>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Complet</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" :value="trial.court.name" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Solutie</label>
              </div>
              <div class="form-group col-md-5">
                <select v-model="type_update" @change="onChange(trial.court)">
                  <option>Amana cauza</option>
                  <option>Hotarare</option>
                </select>
              </div>
            </div>

            <div v-if="type_update === 'Amana cauza'">
              <div class="form-row">
                <div class="form-group col-md-2">
                  <label>Data rejudecarii</label>
                </div>
                <div class="form-group col-md-5">
                  <datepicker-component v-model="newtrial_date" :language='ro'>
                  </datepicker-component>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-2">
                  <label>Complet</label>
                </div>
                <div class="form-group col-md-5">
                  <input type="text" v-model="nextCourt.name" class="form-control">
                </div>
                <div class="form-group col-md-2">
                  <button :disabled="newCourtIsClicked" 
                    @click="newCourt()" type="button" class="btn btn-secondary">Refuza</button>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Tip solutie</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" v-model="solution" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Document</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" v-model="doc" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <button @click="updateTrials(trial.id)" type="button" class="btn btn-secondary">Actualizeaza</button>
              </div>
            </div>
          </div>
          <div v-if="trial.type === 'waiting' && !timePassed(trial.date)">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Data judecarii</label>
              </div>
              <div class="form-group col-md-5">
                <datepicker-component v-model="trial.date" :language='ro' disabled>
                </datepicker-component>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Complet</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" :value="trial.court.name" class="form-control" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
    </form>
  </div>
</template>

<script>
import { ro } from "vuejs-datepicker/dist/locale";
export default {
  props: ["propsFileid"],

  data: function () {
    return {
      file_number: "",
      type_update: "",
      solution: "",
      doc: "",
      pickerdate: new Date(),
      newtrial_date: new Date(),
      nextCourt: {},
      newCourtIsClicked: false,
      courts: [],
      fileCrimes: [],
      crimes: [],
      parts: [],
      trials: [],
      ro: ro,
    };
  },

  methods: {
    getFileData () {
      axios
        .post("/api/file/data", { id: this.propsFileid })
        .then((response) => {
          this.pickerdate = response.data[0].date_registered;

          let parts = response.data[0].date_registered.split("-");
          this.file_number = this.propsFileid + "/183/" + parts[0];

	  this.parts = response.data[0].parts;
	  this.trials = response.data[0].trials;
          this.fileCrimes = response.data[0].crimes;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getCrimes () {
      axios.post('/api/crimes/index')
        .then( response => {
          this.crimes = response.data;
        })
        .catch( error => {
          console.log(error);
        });
    },

    timePassed(date) {
      if (new Date().getTime() >= new Date(date).getTime()) return true;
      return false;
    },

    onChange (court) {
        this.nextCourt = court;
    },

    newCourt () {
      axios
        .post("/api/court/new", { court_id: this.nextCourt.id })
        .then((response) => {
          console.log(response.data);
          this.nextCourt = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
      this.newCourtIsClicked = true;
    },

    updateTrials(trial_id) {
      let data = {
        id: trial_id,
        court_id: this.nextCourt.id,
        type: this.type_update === "Amana cauza" ? "continued" : "ended",
        newtrial_date: this.newtrial_date,
        document: this.doc,
        solution: this.solution,
      };

      axios
        .post("/api/trial/update", data)
        .then((response) => {
          this.trials = response.data;

          this.type_update = "";
          this.doc = '';
          this.solution = '';
          this.newCourtIsClicked = false;
        })
        .catch((error) => {
          console.log(error);
        });
    }
  },

  beforeMount: function () {
    this.getFileData();
    this.getCrimes();
  },

  mounted: function () {}
}
</script>

<style>
.parts > div, .trials > div {
  margin: 20px 0;
  padding-bottom: 10px;
}
.parts > div:not(:last-child), .trials > div:not(:last-child) {
  border-bottom: 1px solid rgb(206, 212, 218);
}
</style>
