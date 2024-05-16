FROM mcr.microsoft.com/playwright:jammy
ENV ROBOT_WORK_DIR /opt/robotframework
RUN mkdir -p ${ROBOT_WORK_DIR}

RUN apt-get update -y && DEBIAN_FRONTEND=noninteractive apt install -y \
    python3  \
    python3-pip \
    python3-tk \
    make \
    && rm -rf /var/lib/apt/lists/*

RUN pip3 install  \
    --no-cache-dir  \
    robotframework  \
    robotframework-browser  \
    robotframework-databaselibrary  \
    robotframework-requests \
    PyMySQL \
    psycopg2-binary \
    robotframework-jsonlibrary \
    tk

RUN rfbrowser init

WORKDIR ${ROBOT_WORK_DIR}

CMD exec /bin/bash -c "trap : TERM INT; sleep infinity & wait"
