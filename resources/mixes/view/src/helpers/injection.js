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
        loading: instance.loading,
        message: instance.message,
        sidebar: instance.sidebar,
    });
    mixinBoard(instance);
    mixinNavigation(instance);
    mixinRouter(instance);
    mixinSidebar(instance);
}

export default Object.assign(injection, {
    install,
});
