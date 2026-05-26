<?php

namespace Botble\Payment\Forms;

use Botble\Base\Forms\FormAbstract;

class PaymentMethodForm extends FormAbstract
{
    protected string $paymentId;
    protected string $paymentName;
    protected string $paymentDescription;
    protected string $paymentLogo;
    protected string $paymentUrl;

    public function paymentId(string $id): self
    {
        $this->paymentId = $id;
        $this->setFormOption('payment_id', $id);
        return $this;
    }

    public function paymentName(string $name): self
    {
        $this->paymentName = $name;
        $this->setFormOption('payment_name', $name);
        return $this;
    }

    public function paymentDescription(string $description): self
    {
        $this->paymentDescription = $description;
        $this->setFormOption('payment_description', $description);
        return $this;
    }

    public function paymentLogo(string $logoUrl): self
    {
        $this->paymentLogo = $logoUrl;
        $this->setFormOption('payment_logo', $logoUrl);
        return $this;
    }

    public function paymentUrl(string $url): self
    {
        $this->paymentUrl = $url;
        $this->setFormOption('payment_url', $url);
        return $this;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getPaymentName(): string
    {
        return $this->paymentName;
    }

    public function getPaymentDescription(): string
    {
        return $this->paymentDescription;
    }

    public function getPaymentLogo(): string
    {
        return $this->paymentLogo;
    }

    public function getPaymentUrl(): string
    {
        return $this->paymentUrl;
    }

    public function renderForm(array $options = [], bool $showStart = true, bool $showFields = true, bool $showEnd = true): string
    {
        $options['formOptions'] = array_merge([
            'payment_id' => $this->paymentId ?? null,
            'payment_name' => $this->paymentName ?? null,
            'payment_logo' => $this->paymentLogo ?? null,
            'payment_url' => $this->paymentUrl ?? null,
            'payment_description' => $this->paymentDescription ?? null,
        ], $options['formOptions'] ?? []);

        return parent::renderForm($options, $showStart, $showFields, $showEnd);
    }
}
