import axios from 'axios'

const setAuthToken = token => {
    if(token){
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
    }else{
        delete axios.defaults.headers.common["Authorization"];
    }
}
export default setAuthToken
export const apiUrl =  'http://127.0.0.1:8000/api'
export const TOKEN = 'token'