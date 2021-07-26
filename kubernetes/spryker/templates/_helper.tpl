{{/* vim: set filetype=mustache: */}}
{{/*
Expand the name of the chart.
*/}}
{{- define "spryker.name" -}}
{{- default .Chart.Name .Values.nameOverride | trunc 63 | trimSuffix "-" -}}
{{- end -}}

{{/*
Create a default fully qualified app name.
We truncate at 63 chars because some Kubernetes name fields are limited to this (by the DNS naming spec).
If release name contains chart name it will be used as a full name.
*/}}
{{- define "spryker.fullname" -}}
{{- if .Values.fullnameOverride -}}
{{- .Values.fullnameOverride | trunc 63 | trimSuffix "-" -}}
{{- else -}}
{{- $name := default .Chart.Name .Values.nameOverride -}}
{{- if contains $name .Release.Name -}}
{{- .Release.Name | trunc 63 | trimSuffix "-" -}}
{{- else -}}
{{- printf "%s-%s" .Release.Name $name | trunc 63 | trimSuffix "-" -}}
{{- end -}}
{{- end -}}
{{- end -}}

{{/*
Create chart name and version as used by the chart label.
*/}}
{{- define "spryker.chart" -}}
{{- printf "%s-%s" .Chart.Name .Chart.Version | replace "+" "_" | trunc 63 | trimSuffix "-" -}}
{{- end -}}

{{/*
Return the apiVersion of statefulset.
*/}}
{{- define "statefulset.apiVersion" -}}
{{- if semverCompare "<1.9-0" .Capabilities.KubeVersion.GitVersion -}}
{{- print "apps/v1beta2" -}}
{{- else if semverCompare ">=1.9-0" .Capabilities.KubeVersion.GitVersion -}}
{{- print "apps/v1" -}}
{{- end -}}
{{- end -}}

{{- define "imagePullSecretGroupSpecs" -}}
{{- printf "{\"auths\": {\"%s\": {\"auth\": \"%s\"}}}" .Values.imageCredentialsGroupSpecs.registry (printf "%s:%s" .Values.imageCredentialsGroupSpecs.username .Values.imageCredentialsGroupSpecs.password | b64enc) | b64enc -}}
{{- end -}}

{{- define "imagePullSecretGroupSpecsProxy" -}}
{{- printf "{\"auths\": {\"%s\": {\"auth\": \"%s\"}}}" .Values.imageCredentialsGroupSpecsProxy.registry (printf "%s:%s" .Values.imageCredentialsGroupSpecsProxy.username .Values.imageCredentialsGroupSpecsProxy.password | b64enc) | b64enc -}}
{{- end -}}

{{- define "imagePullSecretGroupShop" -}}
{{- printf "{\"auths\": {\"%s\": {\"auth\": \"%s\"}}}" .Values.imageCredentialsGroupShop.registry (printf "%s:%s" .Values.imageCredentialsGroupShop.username .Values.imageCredentialsGroupShop.password | b64enc) | b64enc -}}
{{- end -}}

{{- define "brokerStoreEntries" -}}
{{- $release := .Release -}}
{{- $broker := .Values.components.broker -}}
{{- $brokerCreds := .Values.credentials.broker -}}
{{- $dictOut := dict -}}
{{- range $store := .Values.global.stores -}}
{{- $dictOut = merge $dictOut (dict $store (dict "RABBITMQ_CONNECTION_NAME" (printf "%s-connection" ($store | upper)) "RABBITMQ_HOST" ($broker.host) "RABBITMQ_PORT" $broker.port "RABBITMQ_USERNAME" $brokerCreds.username "RABBITMQ_PASSWORD" $brokerCreds.password "RABBITMQ_VIRTUAL_HOST" (printf "%s_queue" ($store | lower)) "RABBITMQ_STORE_NAMES" (list ($store | upper)))) -}}
{{- end -}}
{{- $dictOut | toJson -}}
{{- end -}}

{{- define "brokerVirtualHosts" -}}
{{- $env := .Values.global.GitLabEnv -}}
{{- $listOut := list -}}
{{- range $store := (.Values.global.Stores | split " ") -}}
{{- $listOut = append $listOut (printf "%s-%s" ($store | lower) $env) -}}
{{- end -}}
{{- $listOut | join " " -}}
{{- end -}}

{{- define "brokerVHostsStoresOnly" -}}
{{- $listOut := list -}}
{{- range $store := .Values.global.stores -}}
{{- $listOut = append $listOut (printf "%s_queue" ($store | lower)) -}}
{{- end -}}
{{- $listOut | join " " -}}
{{- end -}}

{{- define "brokerVHosts" -}}
{{- printf "/ %s" (include "brokerVHostsStoresOnly" .) -}}
{{- end -}}

{{- define "brokerConfigVHosts" -}}
{{- $listOut := list -}}
{{- range $vhost := (include "brokerVHosts" . | split " ") -}}
{{- $listOut = append $listOut (dict "name" $vhost) -}}
{{- end -}}
{{ $listOut | toJson }}
{{- end -}}

{{- define "brokerConfigPermissions" -}}
{{- $user := .Values.credentials.broker.username -}}
{{- $listOut := list -}}
{{- range $vhost := (include "brokerVHosts" . | split " ") -}}
{{- $listOut = append $listOut (dict "user" $user "vhost" $vhost "configure" ".*" "write" ".*" "read" ".*") -}}
{{- end -}}
{{ $listOut | toJson }}
{{- end -}}

{{- define "brokerConfigPolicies" -}}
{{- $user := .Values.credentials.broker.username -}}
{{- $listOut := list -}}
{{- range $vhost := (include "brokerVHostsStoresOnly" . | split " ") -}}
{{- $listOut = append $listOut (dict "name" (printf "ha-%s" $vhost) "pattern" ".*" "vhost" $vhost "definition" (dict "ha-mode" "all" "ha-sync-mode" "automatic")) -}}
{{- end -}}
{{ $listOut | toJson }}
{{- end -}}

{{- define "gitlabAnnotations" -}}
app.gitlab.com/app: {{ .Values.global.GitLabAppName }}
app.gitlab.com/env: {{ .Values.global.GitLabEnv }}
{{- end -}}
