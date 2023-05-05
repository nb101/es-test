import axios from "axios";

const API_URL = 'https://dog.ceo/api';

const instance = axios.create({
    baseURL: (API_URL)
});

export default instance;
