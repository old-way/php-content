const injection = {};

function install(instance) {
    console.log(instance);
}

export default Object.assign(injection, {
    install,
});
