import $ from 'jquery';

import {
    mixinBoard,
    mixinNavigation,
    mixinRouter,
    mixinSidebar,
} from '../mixes/injection';

const injection = {};

function install(instance) {
    Object.assign(injection, {
        http: instance.http,
        jquery: $,
        loading: instance.loading,
        message: instance.message,
        sidebar: instance.sidebar,
        trans: instance.trans,
    });
    mixinBoard(instance);
    mixinNavigation(instance);
    mixinRouter(instance);
    mixinSidebar(instance);
}

export default Object.assign(injection, {
    install,
});
