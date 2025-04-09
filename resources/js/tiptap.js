import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'

window.tiptapEditor = (content = '') => {
  return {
    editor: null,
    content: content,
    init() {
      this.editor = new Editor({
        element: this.$refs.editor,
        extensions: [
          StarterKit,
          Placeholder.configure({
            placeholder: 'Tulis isi artikel di sini...',
          }),
        ],
        content: this.content,
        onUpdate: ({ editor }) => {
          this.content = editor.getHTML()
        },
      })
    },
    destroy() {
      if (this.editor) {
        this.editor.destroy()
      }
    }
  }
}
