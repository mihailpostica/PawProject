import ApiService from "./api.service";

export const ArticlesService = {
    query(type, params) {
        return ApiService.query("posts", {
            params: params
        });
    },
    queryUser(params){
        return ApiService.query("user/posts", {
            params: params
        });
    },
    get(slug) {
        const a=ApiService.get("posts", slug);
        return a;
    },
    create(params) {
      const a= ApiService.post("user/posts", params);
      console.log(a)
        return a;
    },
    update(slug, params) {
       const a=ApiService.update("user/posts", slug, params)
        console.log(a)
        return a
    },
    destroy(slug) {
        return ApiService.delete(`user/posts/${slug}`);
    }

};
