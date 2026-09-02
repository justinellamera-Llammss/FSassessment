import axios from "axios";


const api = axios.create({
    baseURL: "/todoApi",
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json"
    }
}) 

export default api;