import Vue from "vue";
import {
    ARTICLE_RESET_STATE,
    FETCH_ARTICLE, FETCH_CURRENTUSER_ARTICLE,
    FETCH_RATINGS,
    RATINGS_CREATE
} from "../action.types";
import {RESET_STATE, SET_ARTICLE, SET_LOADING, SET_RATINGS, UNSET_LOADING} from "../mutations.type";
import {ArticlesService} from "../../common/article.service";
import {RatingsService} from "../../common/ratings.service";


const initialState = {
    article: {},
    ratings: [],
    isArticleLoading: true,
    isRatingsLoading:false,
};

export const state = { ...initialState };

export const actions = {
    async [FETCH_ARTICLE](context, articleSlug, prevArticle) {
        context.commit(SET_LOADING);
        if (prevArticle !== undefined) {
            return context.commit(SET_ARTICLE, prevArticle);
        }
        const { data } = await ArticlesService.get(articleSlug);
        context.commit(UNSET_LOADING);
        context.commit(SET_ARTICLE, data.post);
        return data;
    },
    async [FETCH_CURRENTUSER_ARTICLE](context, articleSlug) {
        context.commit(SET_LOADING);
        const { data } = await ArticlesService.get(articleSlug);
        context.commit(SET_ARTICLE, data.post);
        context.commit(UNSET_LOADING);
        return data;
    },
    async [FETCH_RATINGS](context, articleSlug) {
        context.commit('setRatingsLoading',true)
        const { data } = await RatingsService.get(articleSlug);
        context.commit(SET_RATINGS, data.ratings);
        context.commit('setRatingsLoading',false);
        return data.ratings;
    },
    async [RATINGS_CREATE](context, payload) {
        const rating={
            rating:payload.rating,
            descriere:payload.text
        }
      const a=  await RatingsService.post(payload.slug, rating);
        context.dispatch(FETCH_RATINGS, payload.slug.toString());
        return a;
    },

    [ARTICLE_RESET_STATE]({ commit }) {
        commit(RESET_STATE);
    }
};

export const mutations = {
    [SET_LOADING](state,article){
        state.isArticleLoading=true;
    },
    setRatingsLoading(state,value){
        if (value) {
            state.isRatingsLoading = true
        }else{
            state.isRatingsLoading=false
        }
    },
    [UNSET_LOADING](state,article){
        state.isArticleLoading=false;
    },
    [SET_ARTICLE](state, article) {
        state.article = article;
    },
    [SET_RATINGS](state, ratings) {
        state.ratings = ratings;
    },
    [RESET_STATE]() {
        for (let f in state) {
            Vue.set(state, f, initialState[f]);
        }
    }
};

const getters = {
    article(state) {
        return state.article;
    },
    ratings(state) {
        return state.ratings;
    },
    isArticleLoading(state) {
        return state.isArticleLoading;
    },
    isRatings(state){
        return state.isRatingsLoading;
    }
};

export default {
    state,
    actions,
    mutations,
    getters
};
