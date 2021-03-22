<template>
  <div class="container">
    <form>
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
	    <select v-model="fileCrime.name" @change="onChange($event, index)">
	      <option v-for="crime in crimes">{{ crime.name }}</option>
	    </select>
	  </div>
          <div class="form-group col-md-1 my-auto">
	    <a href="#" @click="deleteCrime(index)">
	      <i class="bi-file-x" style="font-size: 2rem; color: red;"></i>
	    </a>
          </div>
	</div>
      </div>

      <div class="form-group">
        <button @click="addCrime" type="button" class="btn btn-secondary">Adauga obiect</button>
      </div>

      <hr>

      <h2>Parti</h2>
      <div class="parts">

        <div class="form-row" v-for="(part, index) in parts" :key="index">
          <div class="form-group col-md-6">
            <label>Nume</label>
            <input v-model="part.name" :name="`parts[${index}][name]`" type="text" class="form-control" placeholder="Nume">
          </div>
          <div class="form-group col-md-5">
            <label>Calitate parte</label>
            <select v-model="part.type" class="form-control">
              <option>Inculpat</option> 
              <option>Parte civila</option> 
              <option>Parte vatamata</option> 
              <option>Parte responsabila civilmente</option> 
            </select>
          </div>
          <div class="form-group col-md-1 text-center my-auto">
	    <a href="#" @click="deletePart(index)">
	      <i class="bi-file-x" style="font-size: 3rem; color: red;"></i>
	    </a>
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
          <input type="text" v-model="court.name" class="form-control" disabled>
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
let bootbox = require('bootbox');
export default {

  data: function() { 
    return {
      pickerdate: new Date(),
      court: {},
      fileCrimes: [],
      crimes: [],
      parts: [],
      ro: ro
    }
  },

  methods: {
    addPart () {
      this.parts.push({
        name: '',
        type: '',
      })
    },

    addCrime () {
      this.fileCrimes.push({
	id: -1,
        name: '',
      })
    },

    onChange (event, index) {
      console.log(event.target.value);     
      if (this.fileCrimes.some( element => element.id != -1 && element.name === event.target.value))
	bootbox.alert({
	  title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
	  message: "<p>Obiectul a mai fost adaugat.</p>"
	});
      else {
	this.fileCrimes[index].name = event.target.value;
	this.crimes.forEach( element => {
	  if (element.name === event.target.value)
	    this.fileCrimes[index].id = element.id;
	});
      }
      console.log(this.fileCrimes);
    },

    deleteCrime (index) {
      console.log(index);
      this.fileCrimes.splice(index, 1);
    },
    
    deletePart (index) {
      console.log(index);
      this.parts.splice(index, 1);
    },

    //get a random court 
    getCourt () {
      axios.get('/court')
        .then( response => {
          this.court = response.data;
        })
        .catch( error => {
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

    submit () {

      if (!this.fileCrimes.length)
	bootbox.alert({
	  title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
	  message: "<p>Nu au fost adaugate obiecte.</p>"
	});
      else
	if (this.fileCrimes.some(e => e.name ===''))
	  bootbox.alert({
	    title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
	    message: "<p>Obiectul nu a fost selectat din lista.</p>"
	});
	else
	  if (!this.parts.length)
	  bootbox.alert({
	    title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
	    message: "<p>Nu au fost adaugate parti.</p>"
	  });
	  else
	    if (this.parts.some(e => e.name ===''))
	      bootbox.alert({
		title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
		message: "<p>Numele unei parti e necompletat.</p>"
	      });
	    else 
	      if (this.parts.some(e => e.type ===''))
		bootbox.alert({
		  title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
		  message: "<p>Calitatea unei parti e necompletata.</p>"
		});
	      else {
		const data = {
		  crimesIds: this.fileCrimes.map(e => e.id), 
		  date: this.pickerdate,
		  parts: this.parts,
		  court_id: this.court.id
		};
		  
		axios.post('/file/store', data)
		  .then( response => {
		      window.location = 'http://localhost:8000/files';
		  }).catch( error => {
		      console.log(error);
		  });
	      }
    }
  },

  mounted: function() {
    this.getCourt();
    this.getCrimes();
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

