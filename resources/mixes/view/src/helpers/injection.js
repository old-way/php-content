import {
    mixinNavigation,
    mixinRouter,
    mixinSidebar,
} from '../mixes/injection';

const injection = {};

function install(instance) {
    mixinNavigation(instance);
    mixinRouter(instance);
    mixinSidebar(instance);
}

export default Object.assign(injection, {
    install,
});
