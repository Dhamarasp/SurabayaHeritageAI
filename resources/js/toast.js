window.showToast = (message, type = "info", autoDismiss = true) => {
    window.dispatchEvent(
      new CustomEvent("notify", {
        detail: {
          message: message,
          type: type,
          autoDismiss: autoDismiss,
        },
      }),
    )
  }
  