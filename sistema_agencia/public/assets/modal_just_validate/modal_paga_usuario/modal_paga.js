
    document.addEventListener('DOMContentLoaded', function() {
        const validation = new JustValidate('#pagoForm', {
            validateBeforeSubmitting: true,
            errorFieldCssClass: 'is-invalid',
            errorLabelCssClass: 'invalid-feedback'
        });

        validation
            .addField('#userInput', [{
                    rule: 'required',
                    errorMessage: 'El usuario es requerido'
                },
                {
                    rule: 'maxLength',
                    value: 16,
                    errorMessage: 'Máximo 16 caracteres'
                }
            ])
            .addField('#amountInput', [{
                    rule: 'required',
                    errorMessage: 'El monto es requerido'
                },
                {
                    rule: 'number',
                    errorMessage: 'Debe ser un número válido'
                },
                {
                    rule: 'minNumber',
                    value: 1,
                    errorMessage: 'El monto debe ser mayor a 0'
                }
            ])
            .addField('#pagas_motivo', [{
                rule: 'required',
                errorMessage: 'Seleccione una membresía'
            }])
            .addField('#pagas_completo', [{
                rule: 'required',
                errorMessage: 'Seleccione un tipo de pago'
            }])
            .addField('#pagas_rango', [{
                rule: 'required',
                errorMessage: 'Seleccione un rango'
            }])
            .onSuccess((event) => {
                event.target.submit();
            });
    });