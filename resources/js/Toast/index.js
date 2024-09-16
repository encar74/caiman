import { useToast } from 'vue-toastification'
import Toastification from '@/Toast/Toastification'

export const toast = useToast({
  position: "bottom-right",
  // timeout: 5000,
  closeOnClick: false,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  draggable: true,
  draggablePercent: 1,
  showCloseButtonOnHover: false,
  hideProgressBar: false,
  closeButton: false,
  icon: false,
  rtl: false
})

export const primaryToast = ({ title = 'Success', text }) => {
  return toast.success({
    component: Toastification,
    props: {
      variant: 'primary',
      title,
      text,
    },
  })
}

export const successToast = ({ title = 'Success', text }) => {
  return toast.success({
    component: Toastification,
    props: {
      variant: 'success',
      title,
      text,
    },
  })
}

export const errorToast = ({ title = 'Error', text }) => {
  return toast.error({
    component: Toastification,
    props: {
      variant: 'error',
      title,
      text,
    },
  })
}

export const warnToast = ({ title = 'Warning', text }) => {
  return toast.error({
    component: Toastification,
    props: {
      variant: 'warning',
      title,
      text,
    },
  })
}

export const infoToast = ({ title = 'Info', text }) => {
  return toast.error({
    component: Toastification,
    props: {
      variant: 'info',
      title,
      text,
    },
  })
}
