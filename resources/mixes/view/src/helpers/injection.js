import {
    mixinNavigation,
    mixinRouter,
} from '../mixes/injection';

const injection = {};

function install(instance) {
    mixinNavigation(instance);
    mixinRouter(instance);
}

export default Object.assign(injection, {
    install,
});
