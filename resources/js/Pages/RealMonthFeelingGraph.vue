<template>
  <canvas :id="month" width="500" height="400"></canvas> 
</template>
<script>
import Chart from 'chart.js/auto'

export default{
   components:{
     
   },
   props:['positive','neutral','negative','month'],
   
    mounted(){
const ctx = document.getElementById(this.month).getContext('2d');
        new Chart(ctx, {
     type: 'bar',
  data: {
    labels: [this.month],
    datasets: [
      {
        label: 'Positive',
        data: [this.positive],
        backgroundColor: '#D6E9C6',
      },
      {
        label: 'Neutral',
        data: [this.neutral],
        backgroundColor: '#FAEBCC',
      },
      {
        label: 'Negative',
        data: [this.negative],
        backgroundColor: '#EBCCD1',
      }
    ]
  },
  options: {
    scales: {
      xAxes: [{ stacked: true }],
      yAxes: [{ stacked: true }]
    }
  }
});


    }
    }
</script>
