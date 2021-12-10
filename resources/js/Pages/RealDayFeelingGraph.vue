<template>
  <canvas :id="day" width="500" height="400"></canvas> 
</template>
<script>
import Chart from 'chart.js/auto'

export default{
   components:{
     
   },
   props:['positive','neutral','negative','day'],
   
    mounted(){
const ctx = document.getElementById(this.day).getContext('2d');
        new Chart(ctx, {
     type: 'bar',
  data: {
    labels: [this.day],
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
