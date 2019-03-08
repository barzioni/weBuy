import axios from 'axios';
import config from './config';

const instance = axios.create({
   baseURL: config.baseURL,
});



// const reqInterceptor = instance.interceptors.request.use(config => {
//     console.log('Request Interceptor', config);
//     return config
// });
// const resInterceptor = instance.interceptors.response.use(res => {
//     console.log('Response Interceptor', res);
//     return Promise.resolve(res)
// }, (err) => {
//     console.log('Error Interceptor', err);
//     return Promise.reject(err);
// });

// instance.interceptors.request.eject(reqInterceptor);
// instance.interceptors.response.eject(resInterceptor);




// axios.defaults.headers.common['Authorization'] = 'fasfdsa'
// axios.defaults.headers.get['Accepts'] = 'application/json'
// instance.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded';
// instance.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
// instance.defaults.headers.common['Content-Type'] = 'application/json; charset=UTF-8;';
// instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// instance.defaults.headers.common['Authorization'] = 'noAuth';

export default instance;