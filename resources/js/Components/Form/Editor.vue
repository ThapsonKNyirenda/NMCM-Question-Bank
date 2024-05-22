<template>
    <div class="editor" v-if="editor">
        <menu-bar class="editor__header" :editor="editor" />
        <editor-content class="editor__content" :editor="editor" />
    </div>
</template>

<script>
import StarterKit from '@tiptap/starter-kit'
import { Editor, EditorContent } from '@tiptap/vue-3'

import MenuBar from '@/Components/Form/Editor/MenuBar.vue'

export default {
    components: {
        EditorContent,
        MenuBar,
    },

    props: {
        modelValue: {
            type: String,
            default: '',
        },
    },

    emits: ['update:modelValue'],

    data() {
        return {
            editor: null,
        }
    },

    watch: {
        modelValue(value) {
            // HTML
            const isSame = this.editor.getHTML() === value

            // JSON
            // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

            if (isSame) {
                return
            }

            this.editor.commands.setContent(value, false)
        },
    },

    mounted() {
        this.editor = new Editor({
            extensions: [
                StarterKit,
            ],
            content: this.modelValue,
            onUpdate: () => {
                // HTML
                this.$emit('update:modelValue', this.editor.getHTML())

                // JSON
                // this.$emit('update:modelValue', this.editor.getJSON())
            },
        })
    },

    beforeUnmount() {
        this.editor.destroy()
    },
}
</script>
<style lang="scss" scoped>

.editor {
    background-color: #FFF;
    border: 3px solid #0D0D0D;
    border: 1px solid #ccc !important;
    color: #0D0D0D;
    display: flex;
    flex-direction: column;
    max-height: 26rem;
}

.editor__header {
    align-items: center;
    background: #0d0d0d;
    background-color: #fafafa;
    border-bottom: 1px solid #e5e5e5;
    display: flex;
    flex: 0 0 auto;
    flex-wrap: wrap;
    padding: 0.25rem;
    color: #1BC5BD;
}
.editor__header .menu-item
{
    color: #0d0d0d !important;
}
.editor__content {
    flex: 1 1 auto;
    overflow-x: hidden;
    overflow-y: auto;
    padding: 1.25rem 1rem;
    -webkit-overflow-scrolling: touch;
    min-height: 200px;
    border: none;
}

.ProseMirror{
    min-height: 150px;
}

.ProseMirror-focused {
    outline: none;
}
/* Basic editor styles */

.tiptap > * + * {
    margin-top: 0.75em;
}

.tiptap ul,
.tiptap ol {
    padding: 0 1rem;
}

.tiptap h1,
.tiptap h2,
.tiptap h3,
.tiptap h4,
.tiptap h5,
.tiptap h6 {
    line-height: 1.1;
}

.tiptap code {
    background-color: rgba(#616161, 0.1);
    color: #616161;
}

.tiptap pre {
    background: #0D0D0D;
    border-radius: 0.5rem;
    color: #FFF;
    font-family: 'JetBrainsMono', monospace;
    padding: 0.75rem 1rem;
}

.tiptap pre code {
    background: none;
    color: inherit;
    font-size: 0.8rem;
    padding: 0;
}

.tiptap mark {
    background-color: #FAF594;
}

.tiptap img {
    height: auto;
    max-width: 100%;
}

.tiptap hr {
    margin: 1rem 0;
}

.tiptap blockquote {
    border-left: 2px solid rgba(#0D0D0D, 0.1);
    padding-left: 1rem;
}

.tiptap hr {
    border: none;
    border-top: 2px solid rgba(#0D0D0D, 0.1);
    margin: 2rem 0;
}

.tiptap ul[data-type="taskList"] {
    list-style: none;
    padding: 0;
}

.tiptap ul[data-type="taskList"] li {
    align-items: center;
    display: flex;
}
.tiptap ul[data-type="taskList"] li > label {
    flex: 0 0 auto;
    margin-right: 0.5rem;
    user-select: none;
}

.tiptap ul[data-type="taskList"] li > div {
    flex: 1 1 auto;
}

</style>
