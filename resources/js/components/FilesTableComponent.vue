<template>
  <div class="container">
    <table id="files">
      <tr>
	<th>Numar</th>
	<th>Data</th>
	<th>Obiect</th>
	<th>Materie juridica</th>
	<th>Stadiu procesual</th>
      </tr>
      <tr v-for="file in propsFiles" >
	<td> <a :href="'file/' + file.id">{{ file.id }}/183/{{ getYear(file.date_registered) }}</a></td>
	<td>{{ file.date_registered }}</td>
	<td>{{ file.crime }}</td>
	<td>Penal</td>
	<td>Apel</td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  props: ['propsFiles'],
  
  methods: {
    getYear(fulldate) {
      let parts = fulldate.split('-');
      return parts[0];
    }
  }, 

  mounted() {
        console.log(this.propsFiles)
  }
}
</script>

<style>
#files {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#files td, #files th {
  border: 1px solid #ddd;
  padding: 8px;
}

#files tr:nth-child(even){background-color: #f2f2f2;}

#files tr:hover {background-color: #ddd;}

#files th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
