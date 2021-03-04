<template>
  <div class="container">
    <form>
        <div class="form-row">
          <div class="form-group col-md-2">
            <label>Sectie</label>
          </div>
          <div class="form-group col-md-6">
            <input type="text" class="form-control" placeholder="Sectia Civila">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-2">
            <label>Materie</label>
          </div>
          <div class="form-group col-md-6">
            <input type="text" class="form-control" placeholder="Civil">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-2">
            <label>Obiect</label>
          </div>
          <div class="form-group col-md-6">
            <select v-model="crime">
              <option>Luarea de mita</option>
              <option>Traficul de influenta</option>
              <option>Cumpararea de influenta</option>
              <option>Fapte savarsite de catre membrii instantelor de arbitraj sau in legatura cu acestia</option>
              <option>Fapte savarsite de catre functionari straini sau in legatura cu acestia</option>
              <option>Delapidare</option>
              <option>Abuz in serviciu</option>
              <option>Neglijenta in serviciu</option>
              <option>Folosirea abuziva a functiei in scop sexual</option>
              <option>Uzurparea functiei</option>
              <option>Conflict de interese</option>
              <option>Obtinere ilegala de fonduri</option>
              <option>Deturnare de fonduri</option>
              <option>Evaziune fiscala</option>
              <option>Infractiuni asimilate infractiunilor de coruptie</option>
              <option>Spalarea banilor</option>
              <option>Infractiuni impotriva intereselor financiare ale Uniunii Europene</option>
              <option>Masuri si exceptii dispuse de judecatorul de camera preliminara</option>
              <option>Masuri preventive</option>
              <option>Contestatii - Drepturi si Libertati</option>
            </select>
          </div>
        </div>

      <h1>Parti</h1>
      <div class="parts">

        <div class="form-row" v-for="(part, index) in parts" :key="index">
          <div class="form-group col-md-6">
            <label>Nume</label>
            <input v-model="part.name" :name="`parts[${index}][name]`" type="text" class="form-control" placeholder="Nume">
          </div>
          <div class="form-group col-md-6">
            <label>Calitate parte</label>
            <select v-model="part.type" class="form-control">
              <option>Inculpat</option> 
              <option>Parte civila</option> 
              <option>Parte vatamata</option> 
              <option>Parte responsabila civilmente</option> 
            </select>
          </div>
        </div>
      </div>

      <div class="form-group">
        <button @click="addPart" type="button" class="btn btn-secondary">Adauga parte</button>
      </div>
      
      <hr>

      <div class="form-row">
        <div class="form-group col-md-2">
          <label>Data judecarii</label>
        </div>
        <div class="form-group col-md-5">
          <datepicker-component v-model="pickerdate" :language='ro'>
          </datepicker-component>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-2">
          <label>Complet judecata</label>
        </div>
        <div class="form-group col-md-5">
          <input type="text" v-model="court.name" class="form-control">
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-12 text-center">
          <div class="form-group">
            <button @click="submit" type="button" class="btn btn-primary">Adauga dosarul</button>
          </div>
        </div>
      </div>

    </form>
  </div>
</template>

<script>
import {ro} from 'vuejs-datepicker/dist/locale';
export default {

  data: function() { 
    return {
      pickerdate: new Date(),
      court: {},
      crime: '',
      parts: [
        {
          name: "Marius Calmeu",
          type: "Inculpat"
        },
        {
          name: "Anton Man",
          type: "Parte vatamata"
        }
      ],
      ro: ro
    }
  },

  methods: {
    addPart () {
      this.parts.push({
        name: '',
        type: ''
      })
    },

    getCourt () {
      axios.get('/court')
        .then( response => {
          this.court = response.data;
        })
        .catch( error => {
          console.log(error);
        })
    },

    submit () {
      const data = {
        crime: this.crime,
        date: this.pickerdate,
        parts: this.parts,
        court_id: this.court.id
      }
        
      axios.post('/file/store', data)
        .then( response => {
            window.location = 'http://localhost:8000/files';
        }).catch( error => {
            console.log(error);
        })
    }
  },

  mounted: function() {
    this.getCourt()
  }

};
</script>

<style>
.parts > div {
  margin: 20px 0;
  padding-bottom: 10px;
}
.parts > div:not(:last-child) {
  border-bottom: 1px solid rgb(206, 212, 218);
}
</style>

