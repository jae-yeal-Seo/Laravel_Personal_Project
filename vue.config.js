module.exports = {
    devServer:{
      proxy:{
        '/api':{
          target:'https://naveropenapi.apigw.ntruss.com/sentiment-analysis/v1/analyze',
          changeOrigin:true,
          pathRewrite:{
            '^/api':''
          }
        }
      }
    },
    transpileDependencies: [
      'vuetify'
    ]
  }