export const auth = {
    computed: {
        $_auth () {
            return this.$store.getters.auth;
        }
    }
};

export const config = {
    computed: {
        $_config () {
            return window.__CONFIG__;
        }
    }
};
