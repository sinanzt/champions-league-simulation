<template>
    <component class="text-white bg-green-500 hover:bg-green-600 rounded-lg text-sm px-5 py-2.5 mr-2" :is="buttonType" :href="href" :type="type"
        :class="btnClasses">
        <slot></slot>
    </component>
</template>

<script>
export default {
    props: {
        href: {
            required: false,
            type: String,
            default: null
        },
        type: {
            type: String,
            default: "button"
        },
        id: {
            type: String,
            required: false
        },
        name: {
            type: String,
            required: false
        },
        link: Boolean,
    },
    computed: {
        buttonType() {
            if (this.href) {
                return "Link";
            } else {
                return "button";
            }
        }
    },
};
</script>