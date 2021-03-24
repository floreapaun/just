<template>
  <div class="container">
    <div class="search input-group">
      <input type="text" class="form-control" placeholder="Cauta dupa numar dosar, obiect sau parte" 
	v-on:change="event => search(event)">
      <div class="input-group-append">
	<button class="btn btn-secondary" type="button" disabled>
	  <i class="bi bi-search"></i>
	</button>
      </div>
    </div>
    <table id="files">
      <tr>
	<th>Numar</th>
	<th>Data inregistrarii</th>
	<th>Obiecte</th>
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
</template>

<script>
export default {
  data: function() {
    return {
      files: [] 
    }
  },
  
  methods: {
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
    search(event) {
      console.log(event.target.value);
      axios.post('/api/file/search', { term: event.target.value })
        .then( response => {
          console.log(response.data);
          this.files = response.data;
        }).catch( error => {
          console.log(error);
        });
    },
    getFiles() {
      axios.get('/api/files')
        .then( response => {
          console.log(response.data);
          this.files = response.data;
        }).catch( error => {
          console.log(error);
        });
    }
  }, 

  mounted() {
	this.getFiles();
  }
}
</script>

<style>
.search {
  width: 40%;
  margin: 30px auto;
}
</style>
