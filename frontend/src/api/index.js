import axios from 'axios';
import {useToast} from 'vue-toast-notification';
const toast = useToast();

const apiClient = axios.create({
  baseURL: process.env.VUE_APP_BACKEND_URL,
  headers: {
    'Access-Control-Allow-Origin': '*',
    'Content-Type': 'application/json',
  },
});

apiClient.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response) {
      // The request was made and the server responded with a status code
      // that falls out of the range of 2xx
      const { status, data } = error.response;
      console.log(data)
      toast.error(`Error ${status}: ${data.message}`);
    } else if (error.request) {
      // The request was made but no response was received
      toast.error('Request error: No response received');
    } else {
      // Something happened in setting up the request that triggered an Error
      toast.error('Error: Request setup error');
    }
    return Promise.reject(error);
  }
);

export default apiClient;
