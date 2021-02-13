-- a. DISTINCT
Select distinct DEPARTMENT from Worker;

-- b. WHERE (AND, OR, NOT, IN, BETWEEN, LIKE …)
Select * from Worker where SALARY between 100000 and 500000;
Select * from Worker where FIRST_NAME = 'Vipul' OR FIRST_NAME = 'Satish' ;
Select * from Worker where FIRST_NAME in ('Vipul','Satish');
Select * from Worker where FIRST_NAME not in ('Vipul','Satish');
Select * from Worker where DEPARTMENT like 'Admin%';

-- c. ORDER BY
Select * from Worker order by FIRST_NAME asc;
Select * from Worker order by FIRST_NAME asc,DEPARTMENT desc;

-- d. LIMIT
Select DEPARTMENT from Worker LIMIT 5;
        
-- e. JOINS (INNER, LEFT, RIGHT, FULL)
SELECT DISTINCT W.FIRST_NAME, T.WORKER_TITLE
FROM Worker W
INNER JOIN Title T
ON W.WORKER_ID = T.WORKER_REF_ID
AND T.WORKER_TITLE in ('Manager');

SELECT DISTINCT W.FIRST_NAME, T.WORKER_TITLE
FROM Worker W
LEFT JOIN Title T
ON W.WORKER_ID = T.WORKER_REF_ID
AND T.WORKER_TITLE in ('Manager');

SELECT DISTINCT W.FIRST_NAME, T.WORKER_TITLE
FROM Worker W
RIGHT JOIN Title T
ON W.WORKER_ID = T.WORKER_REF_ID
AND T.WORKER_TITLE in ('Manager');

-- f. UNION, UNION ALL
SELECT * FROM Worker WHERE WORKER_ID <=5
union
SELECT * FROM (SELECT * FROM Worker W order by W.WORKER_ID DESC) AS W1 WHERE W1.WORKER_ID <=5;

select FIRST_NAME, DEPARTMENT from Worker W where W.DEPARTMENT='HR' 
union all 
select FIRST_NAME, DEPARTMENT from Worker W1 where W1.DEPARTMENT='HR';

-- g. AGGREGATE FUNCTIONS (COUNT, MIN, MAX, SUM, AVG)
SELECT COUNT(*) FROM Worker WHERE DEPARTMENT = 'Admin';
SELECT DEPARTMENT, sum(Salary) from Worker group by DEPARTMENT;
SELECT DEPARTMENT, avg(Salary) from Worker group by DEPARTMENT;
SELECT FIRST_NAME, SALARY from Worker WHERE SALARY=(SELECT max(SALARY) from Worker);
SELECT FIRST_NAME, SALARY from Worker WHERE SALARY=(SELECT min(SALARY) from Worker);

-- h. GROUP BY
SELECT DEPARTMENT, COUNT(DEPARTMENT) as 'Number of Workers' FROM Worker GROUP BY DEPARTMENT;

-- i. HAVING
SELECT WORKER_TITLE, AFFECTED_FROM, COUNT(*) 
FROM Title
GROUP BY WORKER_TITLE, AFFECTED_FROM
HAVING COUNT(*) > 1;

-- j. Subqueries.
SELECT CONCAT(FIRST_NAME, ' ', LAST_NAME) As Worker_Name, Salary
FROM Worker 
WHERE WORKER_ID IN 
(SELECT WORKER_ID FROM Worker 
WHERE Salary BETWEEN 50000 AND 100000);





