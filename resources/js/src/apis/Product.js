import Api from "./Api";
import Csrf from "./Csrf";

export default {
    async index() {
        await Csrf.getCookie();
        return Api.get("/products");
    },

    async show(id) {
        await Csrf.getCookie();
        return Api.get(`/products/${id}`);
    },

    async store(data) {
        await Csrf.getCookie();
        return Api.post(`/products`,  data);
    },

    async update(id, data) {
        await Csrf.getCookie();
        return Api.put(`/products/${id}`, data);
    },

    async delete(id) {
        await Csrf.getCookie();
        return Api.delete(`/products/${id}`);
    }
};
