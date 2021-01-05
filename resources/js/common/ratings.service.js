import ApiService from "./api.service";
export const RatingsService={


get(slug) {
        return ApiService.get("posts", `${slug}/ratings`);
    },

    post(slug, payload) {
        return ApiService.post(`posts/${slug}/ratings`, payload);
    },


}
