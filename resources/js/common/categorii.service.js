import ApiService from "./api.service";
export const CategoriiService = {
query() {
    return ApiService.query("/categories");
}
}
