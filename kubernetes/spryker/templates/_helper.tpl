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

{{- define "env.common" -}}
KUBE_NAMESPACE: "{{ .Release.Namespace }}"
SPRYKER_OAUTH_CLIENT_IDENTIFIER: "frontend"
SPRYKER_LOG_STDOUT: "php://stdout"
SPRYKER_LOG_STDERR: "php://stdout"
SPRYKER_BROKER_ENGINE: "rabbitmq"
SPRYKER_BROKER_API_HOST: {{ .Values.components.broker.host }}
SPRYKER_BROKER_API_PORT: {{ .Values.components.broker.apiPort | quote}}
SPRYKER_BROKER_HOST: {{ .Values.components.broker.host }}
SPRYKER_BROKER_PORT: {{ .Values.components.broker.port | quote }}
SPRYKER_KEY_VALUE_STORE_HOST: "{{ .Values.components.keyValueStore.name }}-master"
SPRYKER_KEY_VALUE_STORE_PORT: "6379"
SPRYKER_SEARCH_ENGINE: "ES"
SPRYKER_SEARCH_HOST: "search"
SPRYKER_SEARCH_PORT: "9200"
SPRYKER_SEARCH_INDEX_PREFIX: "beta-shop"
SPRYKER_SESSION_BE_HOST: "{{ .Values.components.sessions.name }}-master"
SPRYKER_SESSION_BE_PORT: "6379"
SPRYKER_SESSION_FE_HOST: "{{ .Values.components.sessions.name }}-master"
SPRYKER_SESSION_FE_PORT: "6379"
SPRYKER_DB_HOST: "{{ .Values.components.database.name }}"
SPRYKER_DB_PORT: "5432"
SPRYKER_DB_DATABASE: "eu-staging"
SPRYKER_DEBUG_ENABLED: "1"
SPRYKER_DEBUG_PROPEL_ENABLED: "1"
SPRYKER_SCHEDULER_HOST: {{ .Values.components.scheduler.name }}
SPRYKER_SCHEDULER_PORT: {{ .Values.components.scheduler.port | quote }}
SPRYKER_JENKINS_TEMPLATE_PATH: {{ .Values.components.scheduler.templatePath }}
{{- end -}}

{{- define "secrets.common" -}}
SPRYKER_BROKER_CONNECTIONS: {{ include "brokerStoreEntries" . | quote }}
SPRYKER_BROKER_API_USERNAME: {{ .Values.credentials.broker.apiUsername }}
SPRYKER_BROKER_API_PASSWORD: {{ .Values.credentials.broker.password }}
SPRYKER_BROKER_USERNAME: {{ .Values.credentials.broker.username }}
SPRYKER_BROKER_PASSWORD: {{ .Values.credentials.broker.password }}
SPRYKER_DB_USERNAME: "{{ .Values.credentials.database.username }}"
SPRYKER_DB_PASSWORD: "{{ .Values.credentials.database.password }}"
SPRYKER_DB_ROOT_USERNAME: "{{ .Values.credentials.database.rootUsername }}"
SPRYKER_DB_ROOT_PASSWORD: "{{ .Values.credentials.database.rootPassword }}"
{{- end -}}
