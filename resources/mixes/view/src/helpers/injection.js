import {
    mixinRouter,
} from '../mixes/injection';

const injection = {};

function install(instance) {
    mixinRouter(instance);
    console.log(instance);
}

export default Object.assign(injection, {
    install,
});
