import Vue from 'vue'
import axios from 'axios'

axios.defaults.baseURL = '/api/v1'

Vue.prototype.$http = axios


export default axios
