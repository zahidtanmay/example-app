import Api from "./Api";
import Csrf from "./Csrf";

export default {
    async index() {
        await Csrf.getCookie();
        return Api.get("/todos");
    },

    async store(data) {
        await Csrf.getCookie();
        return Api.post(`/todos`, { description: data });
    },

    async update(id) {
        await Csrf.getCookie();
        return Api.put(`/todos/${id}`);
    },

    async delete(id) {
        await Csrf.getCookie();
        return Api.delete(`/todos/${id}`);
    }
};
