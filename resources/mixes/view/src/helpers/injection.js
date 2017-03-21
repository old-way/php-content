// import Vue from 'vue';
// import camelcase from 'camelcase';
// import decamelize from 'decamelize';

import {
    mixinNavigation,
    mixinRouter,
    mixinSidebar,
} from '../mixes/injection';

const injection = {};

function install(instance) {
    Object.assign(injection, {
        sidebar: instance.sidebar,
    });
    mixinNavigation(instance);
    mixinRouter(instance);
    mixinSidebar(instance);

    // Object.keys(instance.components).forEach(key => {
    //     Vue.component(decamelize(camelcase(key), '-'), instance.components[key]);
    // });
}

export default Object.assign(injection, {
    install,
});
