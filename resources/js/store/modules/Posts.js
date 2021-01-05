import {
    ARTICLE_DELETE,
    ARTICLE_EDIT,
    ARTICLE_PUBLISH,
    FETCH_ARTICLE,
    FETCH_RATINGS,
    FETCH_USER_ARTICLES, RATINGS_CREATE
} from "../action.types";
import {FETCH_DELETE_END, FETCH_USER_END, FETCH_USER_START, SET_ARTICLE} from "../mutations.type";
import {ArticlesService} from "../../common/article.service";


const state = {
    userPosts: [],
    isUserPostsLoading: true,
    userPostsCount: 0
};
const getters = {
    userPostsCount(state) {
        return state.userPostsCount;
    },
    userPosts(state) {
        return state.userPosts
    },
    isUserPostsLoading(state) {
        return state.isUserPostsLoading;
    },
};
const actions = {


    [FETCH_USER_ARTICLES]({ commit }, params) {
        commit(FETCH_USER_START);
        return ArticlesService.queryUser(params.type)
            .then(({ data }) => {
                commit(FETCH_USER_END, data);
            })
            .catch(error => {
                throw new Error(error);
            });
    },
    [ARTICLE_PUBLISH]({commit},params){
        const a=ArticlesService.create(params);
        return a;
    },
    [ARTICLE_DELETE]({commit}, slug) {
        commit(FETCH_USER_START);
        return ArticlesService.destroy(slug).then(({ data }) => {
            commit(FETCH_DELETE_END, data);
        })
            .catch(error => {
                throw new Error(error);
            });
    },
    [ARTICLE_EDIT]({commit},payload){
        return ArticlesService.update(payload.id, payload);
    }

};
const mutations = {
    [FETCH_USER_START](state) {
        state.isUserPostsLoading = true;
    },
    [FETCH_DELETE_END](state){
      state.isUserPostsLoading=false;
    },
    [FETCH_USER_END](state, { data, total }) {
        state.userPosts = data;
        state.userPostsCount = total;
        state.isUserPostsLoading = false;
    }
};
export default {
    actions,
    mutations,
    state,
    getters
}
