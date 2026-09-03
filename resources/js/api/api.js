import axios from "axios";

const BASE = "http://127.0.0.1:8000/api";


const api = axios.create({
    baseURL: `${BASE}`,
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json"
    }
}) 

export default api;