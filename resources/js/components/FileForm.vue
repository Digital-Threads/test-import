<script setup lang="ts">
import { setErrors } from '@formkit/vue';
import axios from 'axios';
import { ref } from 'vue';

const VITE_BACKEND_API_BASE_URL = import.meta.env.VITE_BACKEND_API_BASE_URL;

const complete = ref(false)

interface FormData {
    key: string,
    text: string,
    file: []
}

type File = {
    file: Blob
}

const submitHandler = async (data: FormData) => {

    const body = new FormData()

    body.append('key', data.key)
    body.append('text', data.text)

    data.file.forEach((fileItem: File) => {
        body.append('file', fileItem.file)
    })

    await axios.post(VITE_BACKEND_API_BASE_URL+'replace',
        body,
        {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
            'responseType': 'blob'
        }
    ).then(function (response) {
        complete.value = true

        const blob = new Blob([response.data], { type: 'application/pdf' })

        if (window.navigator['msSaveOrOpenBlob']) {
            window.navigator['msSaveBlob'](blob, 'result_file.pdf')
        } else {
            const elem = window.document.createElement('a')

            elem.href = window.URL.createObjectURL(blob)
            elem.download = 'result_file.pdf'
            document.body.appendChild(elem)
            elem.click()

            setTimeout(function () {
                window.URL.revokeObjectURL(elem.href)
            }, 100)
            document.body.removeChild(elem)
        }
    })
        .catch(function () {
            setErrors('testTaskForm', ['The server didn’t like our request.'])
        });
}

const tryAgain = () => complete.value = false

</script>

<template>
    <FormKit
        v-if="!complete"
        id="testTaskForm"
        type="form"
        @submit="submitHandler"
    >
        <FormKit
            type="text"
            label="Key"
            help="The key which you want replace"
            name="key"
            validation="required"
        />
        <FormKit
            type="text"
            label="Some text"
            help="The text will be replaced in the attached file"
            name="text"
            validation="required"
        />
        <FormKit
            type="file"
            label="Word file"
            name="file"
            help="Please attach only the .doc or .docx file"
            accept=".docx,.doc"
            validation="required"
        />
    </FormKit>
    <div v-else class="complete">File upload complete 👍
        <FormKit
            type="button"
            label="Try again"
            @click="tryAgain"
        />
    </div>
</template>
