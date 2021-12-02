<template>
  <div class="container">
    <div v-if="showCourts">
      <div class="form-row">
	<div class="form-group col-md-2">
	  <label>Data</label>
	</div>
	<div class="form-group col-md-5">
	  <datepicker-component @selected="dateSelected()" v-model="pickerdate" :language='ro'>
	  </datepicker-component>
	</div>
      </div>
      <div class="form-row">
	<div class="form-group col-md-4">
	  <p>Pentru a afisa sedintele va rugam alegeti o data</p>
	</div>
      </div>
    
      <table>
	<tr>
	  <th>Sectie</th>
	  <th>Complet</th>
	  <th>Ora</th>
	</tr>
	<tr v-for="court in courts">
	  <td>Penal</td>
	  <td><a href="#" @click="showFiles(court.id)">{{ court.name }}</a></td>
	  <td>09:00</td>
	</tr>
      </table>
    </div>

    <div v-if="!showCourts">
      <div v-if="files.length">
	<table>
	  <tr>
	    <th>Numar</th>
	    <th>Data inregistrarii</th>
	    <th>Obiect</th>
	    <th>Materie juridica</th>
	    <th>Stadiu procesual</th>
	  </tr>
	  <tr v-for="file in files" >
	    <td> <a :href="'file/' + file.id">{{ file.id }}/183/{{ getYear(file.date_registered) }}</a></td>
	    <td>{{ changeFormat(file.date_registered) }}</td>
	    <td><p v-for="crime in file.crimes">{{ crime.name }}</p></td>
	    <td>Penal</td>
	    <td>Apel</td>
	  </tr>
	</table>
      </div>
      <div v-else class="form-row">
        <div class="col-md-12 text-center">
	  <p>Nu exista informatii.</p>
	</div>
      </div>
      <div class="form-row">
        <div class="col-md-12 text-center">
          <div class="form-group">
            <button @click="removeFiles()" type="button" class="btn btn-primary btn-back">Inapoi</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import {ro} from 'vuejs-datepicker/dist/locale';
export default {
  data: function() { 
    return {
      showCourts: true,
      courts: [],
      files: [],
      pickerdate: new Date(),
      ro: ro
    }
  },

  methods: {
    dateSelected() {
      this.$nextTick(() => { this.getFileData(); }); 
    },

    getYear(fulldate) {
      let parts = fulldate.split('-');
      return parts[0];
    },

    changeFormat(fulldate) {
      let d = new Date(fulldate),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

      if (month.length < 2) 
	  month = '0' + month;
      if (day.length < 2) 
	  day = '0' + day;

      return [day, month, year].join('/');
    },

    showFiles(courtId) {
      this.showCourts = false;
      this.courts.forEach(court => { 
        if (court.id === courtId) {
          this.files = court.files;
        }
      });
    },
  
    removeFiles() {
      this.showCourts = true;
    },

    getFileData() {
      axios.post('/api/trials/courts', { date: this.pickerdate })
        .then( response => {
	  this.courts = response.data;
	})
	.catch( error => {
	  console.log(error);
	});
	
    },
  },

  beforeMount: function() {
    this.getFileData();
  },

  mounted: function() {
  }


};
</script>

<style>
table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

table td, table th {
  border: 1px solid #ddd;
  padding: 8px;
}

table tr:nth-child(even){background-color: #f2f2f2;}

table tr:hover {background-color: #ddd;}

table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}

.btn-back {
  margin: 10px;
}

</style>
