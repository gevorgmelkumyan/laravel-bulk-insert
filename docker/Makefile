run:
	chmod +x update.env.sh
	bash update.env.sh
	docker compose build
	docker compose -f docker-compose.yml up --remove-orphans -d

stop:
	docker compose -f docker-compose.yml stop

down:
	docker compose -f docker-compose.yml down -v --rmi=all --remove-orphans

server_run:
	docker exec -it lbi_server bash
